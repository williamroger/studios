import { Component, OnInit } from '@angular/core';
import { NavController} from '@ionic/angular';
import { SchedulingService } from './shared/scheduling.service';
import { RoomService } from '../rooms/shared/room.service';
import { SchedulingModel } from './shared/SchedulingModel';
import { FormGroup, FormBuilder, FormControl, Validators } from '@angular/forms';
import { LoadingController } from '@ionic/angular';
import { ToastController } from '@ionic/angular';
import { PeriodModel } from './shared/PeriodModel';
import { AuthService } from '../login/shared/auth.service';
import { RoomModel } from '../rooms/shared/RoomModel';


@Component({
  selector: 'app-scheduling',
  templateUrl: './scheduling.page.html',
  styleUrls: ['./scheduling.page.scss'],
})
export class SchedulingPage implements OnInit {

  public selectRadioGroup: any;
  public selectRadioItem: any;
  periods: Array<PeriodModel>
  schedulingForm: FormGroup;
  public room: RoomModel;
  scheduling: SchedulingModel = new SchedulingModel();
  //public myDate = new Date().toISOString();

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
    this.builSchedulingForm();
  }

  radioGroup(event) {
    this.selectRadioGroup = event.detail;
  }

  radioSelect(event) {
    this.selectRadioItem = event.detail;
  }

  submitForm() {
    const scheduling: SchedulingModel = Object.assign(new SchedulingModel(), this.schedulingForm.value);
    //const timePeriod: PeriodModel = Object.assign(new PeriodModel(), this.schedulingForm.value);
    this.presentLoading();

    this.service.insertScheduling(this.schedulingForm.value)
    .subscribe(
      studio => this.actionsForSuccess(this.schedulingForm.value),
      error => this.actionsForError(error)
    )
    //console.log(this.schedulingForm.value);
  }

  builSchedulingForm() {
    this.schedulingForm = this.formBuilder.group({
      id: [null],
      dateScheduling: new FormControl(null),
      //status: [0],
      customerId: [this.service.userLocalStorage['customer_id']],
      comment: ["minha banda toca muito"/*null, [Validators.required, Validators.maxLength(150)]*/],
      periodId: [3/*this.scheduling.periodId*/]
    });
  }

  periodHandler(event) {
    this.scheduling.periodId = event.target.value;
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
