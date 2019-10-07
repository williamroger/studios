import { Component, OnInit } from '@angular/core';
import { NavController} from '@ionic/angular';
import { SchedulingService } from './shared/scheduling.service';
import { RoomService } from '../rooms/shared/room.service';
import { RoomModel } from './shared/RoomModel';
import { SchedulingModel } from './shared/SchedulingModel';
import { FormGroup, FormBuilder, FormControl, Validators } from '@angular/forms';
import { LoadingController } from '@ionic/angular';
import { ToastController } from '@ionic/angular';
import { PeriodModel } from './shared/PeriodModel';
import { AuthService } from '../login/shared/auth.service';


@Component({
  selector: 'app-scheduling',
  templateUrl: './scheduling.page.html',
  styleUrls: ['./scheduling.page.scss'],
})
export class SchedulingPage implements OnInit {

  periods: Array<PeriodModel>
  schedulingForm: FormGroup;
  public room: RoomModel;
  public scheduling: SchedulingModel = new SchedulingModel();

  constructor(public service: SchedulingService,
              public roomService: RoomService,
              public auth: AuthService,
              public nav: NavController,
              public formBuilder: FormBuilder,
              public toastr: ToastController,
              public loading: LoadingController) { }

  ngOnInit() {
    this.room = this.roomService.getRoom();
    this.loadPeriods();
  }

  submitForm() {
    const scheduling: SchedulingModel = Object.assign(new SchedulingModel(), this.schedulingForm.value);

    this.presentLoading();

    this.service.insertScheduling(scheduling)
    .subscribe(
      studio => this.actionsForSuccess(scheduling),
      error => this.actionsForError(error)
    )
  }

  builSchedulingForm() {
    this.schedulingForm = this.formBuilder.group({
      id: [null],
      dateScheduling: [null, [Validators.required]],
      status: [0],
      customerId: [this.service.userLocalStorage['customer_id']],
      comment: [null, [Validators.required, Validators.maxLength(150)]]
    });
  }

  loadPeriods() {
    this.service.getPeriodsByRoomId(this.room.id).subscribe(
      periods => this.periods = periods
    );
  }

  async presentLoading() {
    const loading = await this.loading.create({
      message: 'Cadastrando',
      duration: 1000
    });
    await loading.present();

    const { role, data } = await loading.onDidDismiss();
  }

  async presentToast(message: string) {
    const toast = await this.toastr.create({
      message,
      duration: 2000,
      color: 'primary'
    });
    toast.present();
  }

  actionsForSuccess(scheduling: SchedulingModel) {
    this.presentToast('Agendado com sucesso!');
  }

  actionsForError(error) {
    this.presentToast('Ocorreu um erro, tente novamente!');
  }
}
