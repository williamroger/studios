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

  public selectDate: any;
  public selectRadioGroup: any;
  periods: Array<PeriodModel>
  schedulingForm: FormGroup;
  public room: RoomModel;
  public period: PeriodModel = new PeriodModel();
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

  dateSchedule(event) {
    this.selectDate = event.detail;
    this.loadPeriodsFree();
    console.log(this.loadPeriodsFree());
  }

  submitForm() {
    const scheduling: SchedulingModel = Object.assign(new SchedulingModel(), this.schedulingForm.value);
    this.presentLoading();

    this.service.insertScheduling(this.schedulingForm.value)
    .subscribe(
      studio => this.actionsForSuccess(this.schedulingForm.value),
      error => this.actionsForError(error)
    )
    console.log(this.schedulingForm.value);
    console.log(this.selectRadioGroup);
  }

  builSchedulingForm() {
    this.schedulingForm = this.formBuilder.group({
      id: [null],
      date_scheduling: new FormControl(null),
      customer_id: [this.service.userLocalStorage['customer_id']],
      time_period_id: new FormControl(this.selectRadioGroup),
      comment: new FormControl(null, Validators.compose([Validators.required, Validators.maxLength(150)]))
    });
  }

  periodHandler(event) {
    this.scheduling.time_period_id = this.selectRadioGroup;
    console.log(this.scheduling.time_period_id);
  }

  loadPeriods() {
    this.service.getPeriodsByRoomId(this.room.id).subscribe(
      periods => this.periods = periods
    );
  }

  loadPeriodsFree() {
    this.service.getPeriodsFreeByRoomIdAndDate(this.room.id, this.period.day, this.scheduling.date_scheduling)
    .subscribe(
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
