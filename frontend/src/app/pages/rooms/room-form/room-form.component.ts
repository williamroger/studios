import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

import { RoomModel } from '../shared/room.model';
import { RoomsService } from '../shared/rooms.service';
import { AuthService } from 'src/app/auth.service';
import { ImageService } from 'src/app/shared/image.service';

import { switchMap } from 'rxjs/operators';

import toastr from 'toastr';
import { HttpEventType } from '@angular/common/http';

@Component({
  selector: 'app-room-form',
  templateUrl: './room-form.component.html',
  styleUrls: ['./room-form.component.scss']
})
export class RoomFormComponent implements OnInit {

  currentAction: string;
  roomForm: FormGroup;
  pageTitle: string;
  serverErrorMessage: string[] = null;
  submittingForm: boolean = false;
  room: RoomModel = new RoomModel();

  // upload image
  fileData: File = null;
  previewUrl: any = null;
  fileUploadProgress: string = null;

  imaskNumber = {
    mask: Number,
    min: 1,
    max: 50
  }

  constructor(
    private roomService: RoomsService,
    private route: ActivatedRoute,
    private router: Router,
    private formBuilder: FormBuilder,
    private authService: AuthService,
    private imageService: ImageService
  ) { }

  ngOnInit() {
    this.setCurrentAction();
    this.buildRoomForm();
    this.loadRoom();
    // get image to api
    this.getImageFromService();
  }

  ngAfterContentChecked() {
    this.setPageTitle();
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
    const idRoom = +this.route.snapshot.url[0].path;

    this.imageService.getImage(`studio/${idStudio}/getimageroom/${idRoom}`).subscribe(data => {
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

  submitUploadImage() {
    const formData = new FormData();
    const idRoom = +this.route.snapshot.url[0].path;

    formData.append('image', this.fileData);

    this.fileUploadProgress = '0%';
    this.roomService.uploadImage(formData, idRoom)
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

    if (this.currentAction == 'new')
      this.createRoom();
    else
      this.updateRoom();
  }

  // Private Methods
  private setCurrentAction() {
    if (this.route.snapshot.url[0].path == 'new')
      this.currentAction = 'new';
    else
      this.currentAction = 'edit';
  }

  private buildRoomForm() {
    this.roomForm = this.formBuilder.group({
      id: [null],
      name: [null, [Validators.required, Validators.minLength(4)]],
      description: [null, [Validators.required, Validators.minLength(20)]],
      studio_id: [this.authService.userLoggedIn['studio_id']],
      maximum_capacity: [null, [Validators.required, Validators.minLength(1)]],
      color: [null, [Validators.required, Validators.minLength(4)]]
    });
  }

  private loadRoom() {
    if (this.currentAction == "edit") {
      this.route.paramMap.pipe(
        switchMap(params => this.roomService.getById(+params.get("id")))
      )
      .subscribe(
        (room) => {
          this.room = room[0];
          this.roomForm.patchValue(room[0])
        },
        (error) => alert("Ocorreu um erro no servidor, tente mais tarde.")
      )
    }
  }

  private setPageTitle() {
    if (this.currentAction == 'new') {
      this.pageTitle = 'Cadastrar nova Sala de Ensaio';
    } else {
      const roomName = this.room.name || '';

      this.pageTitle = `Editar Sala ${roomName}`;
    }
  }

  private createRoom() {
    const room: RoomModel = Object.assign(new RoomModel(), this.roomForm.value);

    this.roomService.create(room)
      .subscribe(
        room => this.actionsForSuccess(room, 'Nova sala criada com sucesso!'),
        error => this.actionsForError(error)
      )
  }

  private updateRoom() {
    const room: RoomModel = Object.assign(new RoomModel(), this.roomForm.value);

    this.roomService.update(room)
      .subscribe(
        category => this.actionsForSuccess(room, 'Sala de ensaio atualizada com sucesso!'),
        error => this.actionsForError(error)
      );
  }

  private actionsForSuccess(room: RoomModel, message: string) {
    toastr.success(message);
    this.submittingForm = false;

    // redirect / reload / component page
    if (this.currentAction == 'new') {
      setTimeout(() => {
        this.router.navigateByUrl('/salas');
      }, 3000);
    } else {
      this.router.navigateByUrl('salas', { skipLocationChange: true }).then(
        () => this.router.navigate(['salas', room.id, 'edit'])
      );
    }
  }

  private actionsForError(error) {
    toastr.error('Ocorreu um erro na aplicação, tento novamente!');

    this.submittingForm = false;

    if (error.status === 422)
      this.serverErrorMessage = JSON.parse(error._body).errors;
    else
      this.serverErrorMessage = ['Falha na comunicação com o servidor. Por favor, tente mais tarde.'];
  }
}
