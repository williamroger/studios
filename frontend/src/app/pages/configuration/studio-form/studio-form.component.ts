import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

import { AuthService } from 'src/app/auth.service';
import { ConfigurationService } from './../shared/configuration.service';
import { CityModel } from '../shared/city.mode';
import { StudioModel } from './../shared/studio.model';

import toastr from 'toastr';
import { HttpEventType } from '@angular/common/http';
import { ImageService } from 'src/app/shared/image.service';

@Component({
  selector: 'app-studio-form',
  templateUrl: './studio-form.component.html',
  styleUrls: ['./studio-form.component.scss']
})
export class StudioFormComponent implements OnInit {

  configForm: FormGroup;
  cities: Array<CityModel>;
  studio: StudioModel = new StudioModel();
  submittingForm: boolean = false;

  // upload image
  fileData: File = null;
  previewUrl: any = null;
  fileUploadProgress: string = null;

  // iMasks
  imaskCEP = {
    mask: '00000-000'
  }

  imaskNumber = {
    mask: Number
  }

  imaskTelephone = {
    mask: '(00) 0000-0000'
  }

  imaskPhone = {
    mask: '(00) 00000-0000'
  }

  imaskCNPJ = {
    mask: '00.000.000/0000-00'
  }

  constructor(private configService: ConfigurationService,
              private formBuilder: FormBuilder,
              private imageService: ImageService,
              private authService: AuthService) { }

  ngOnInit() {
    this.loadCities();
    this.loadConfigForm();
    this.buildConfigForm();
    // get image to api
    this.getImageFromService();
  }
  // Get Image to API
  createImageFromBlob(image: Blob) {
    let reader = new FileReader();
    reader.addEventListener("load", () => {
      this.previewUrl = reader.result;
    }, false);

    if (image) {
      reader.readAsDataURL(image);
    }
  }

  getImageFromService() {
    const idStudio = this.authService.userLoggedIn['studio_id'];

    this.imageService.getImage(`studio/${idStudio}/getlogostudio`).subscribe(data => {
      this.createImageFromBlob(data);
    }, error => {
      console.log('error ', error);
    });
  }
  // End Get Image to API

  // upload files
  fileProgress(fileInput: any) {
    this.fileData = <File>fileInput.target.files[0];
    this.preview();
  }

  preview() {
    // show privew
    let mimType = this.fileData.type;
    if (mimType.match(/image\/*/) === null)
      return;

    let reader = new FileReader();
    reader.readAsDataURL(this.fileData);
    reader.onload = (_event) => {
      this.previewUrl = reader.result;
    }
  }

  submitUploadLogo() {
    const formData = new FormData();
    formData.append('logostudio', this.fileData);

    this.fileUploadProgress = '0%';
    this.configService.uploadLogo(formData)
    .subscribe(events => {
        if (events.type === HttpEventType.UploadProgress) {
          this.fileUploadProgress = Math.round(events.loaded / events.total * 100) + '%';
        } else if (events.type === HttpEventType.Response) {
          this.fileUploadProgress = '';
          if (events.body.success)
            toastr.success(events.body.msg);
          else
            toastr.error(events.body.msg);
        }
      }
    )
  }

  submitForm() {
    this.submittingForm = true;

    const studioUser: StudioModel = Object.assign(new StudioModel(), this.configForm.value);
    const userLoggedIn = JSON.parse(localStorage.getItem('userLoggedIn'));

    this.configService.update(studioUser)
      .subscribe(
        data => {
          this.actionsForSuccess('Dados do estúdio atualizado com sucesso!');

          userLoggedIn.city_id = data.city_id;
          localStorage.removeItem('userLoggedIn');
          localStorage.setItem('userLoggedIn', JSON.stringify(userLoggedIn));
          setTimeout(() => {
            this.refresh();
          }, 3000);
        },
        error => {
          this.actionsForError(error.msgDev)
        }
      )
  }

  // Methods Private
  private loadCities() {
    this.configService.getCitiesByStateId()
      .subscribe(
        cities => this.cities = cities
      );
  }

  private loadConfigForm() {
    this.configService.getStudioById()
      .subscribe(
        (studio) => {
          this.studio = studio
          this.configForm.patchValue(studio)
        }
      );
  }

  private buildConfigForm() {
    this.configForm = this.formBuilder.group({
      id: [null],
      name: [null, [Validators.required, Validators.minLength(4)]],
      phone: [null],
      description: [null, [Validators.required, Validators.minLength(100)]],
      cnpj: [null],
      telephone: [null],
      has_parking: [null, [Validators.required]],
      has_wifi: [null, [Validators.required]],
      is_24_hours: [null, [Validators.required]],
      city_id: [null, [Validators.required]],
      rate_cancellation: [0],
      days_cancellation: [0],
      zip_code: [null, [Validators.required, Validators.minLength(9)]],
      street: [null, [Validators.required, Validators.minLength(10)]],
      complement: [null],
      district: [null, [Validators.required, Validators.minLength(5)]],
      number: [null, [Validators.required, Validators.minLength(2)]],
      image: ['imagepath']
    });
  }

  private actionsForSuccess(message: string) {
    toastr.success(message);
    this.submittingForm = false;
  }

  private actionsForError(error) {
    this.submittingForm = false;
    toastr.error(error);
  }

  private refresh() {
    window.location.reload();
  }
}
