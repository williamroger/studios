import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

import { RoomModel } from '../shared/room.model';
import { RoomsService } from '../shared/rooms.service';

import { switchMap } from 'rxjs/operators';

import toastr from 'toastr';

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

  constructor(
    private roomService: RoomsService,
    private route: ActivatedRoute,
    private router: Router,
    private formBuilder: FormBuilder
  ) { }

  ngOnInit() {
    this.setCurrentAction();
    this.buildRoomForm();
    this.loadRoom();
  }

  ngAfterContentChecked() {
    this.setPageTitle();
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
      studio_id: [1],
      maximum_capacity: [null, [Validators.required, Validators.minLength(1)]],
      color: [null, [Validators.required, Validators.minLength(3)]]
    });
  }

  private loadRoom() {
    if (this.currentAction == "edit") {
      this.route.paramMap.pipe(
        switchMap(params => this.roomService.getById(+params.get("id")))
      )
      .subscribe(
        (room) => {
          this.room = room;
          this.roomForm.patchValue(room)
        },
        (error) => alert("Ocorreu um erro no servidor, tente mais tarde.")
      )
    }
  }

  private setPageTitle() {
    if (this.currentAction == 'new')
      this.pageTitle = 'Cadastrar nova Sala de Ensaio';
    else {
      const roomName = this.room.name || '';

      this.pageTitle = `Editando Sala de Ensaio ${roomName}`;
    }
  }

  private createRoom() {
    const room: RoomModel = Object.assign(new RoomModel(), this.roomForm.value);

    this.roomService.create(room)
      .subscribe(
        room => this.actionsForSuccess(room),
        error => this.actionsForError(error)
      )
  }

  private updateRoom() {
    const room: RoomModel = Object.assign(new RoomModel(), this.roomForm.value);

    this.roomService.update(room)
      .subscribe(
        category => this.actionsForSuccess(room),
        error => this.actionsForError(error)
      );
  }

  private actionsForSuccess(room: RoomModel) {
    toastr.success('Nova sala criada com sucesso!');

    // redirect / reload / component page
    this.router.navigateByUrl('salas', {skipLocationChange: true}).then(
      () => this.router.navigate(['salas', room.id, 'edit'])
    );
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
