import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

import { ConfigurationService } from './../shared/configuration.service';
import { CityModel } from '../shared/city.mode';
import { StudioModel } from './../shared/studio.model';

import toastr from 'toastr';

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

  constructor(private configService: ConfigurationService,
              private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.loadCities();
    this.loadConfigForm();
    this.buildConfigForm();
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

  actionsForSuccess(message: string) {
    toastr.success(message);
    this.submittingForm = false;
  }

  actionsForError(error) {
    this.submittingForm = false;
    toastr.error(error);
  }
}
