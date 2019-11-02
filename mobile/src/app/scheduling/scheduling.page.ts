import { StudioModel } from './../home/shared/StudioModel';
import { Component, OnInit } from '@angular/core';
import { NavController} from '@ionic/angular';
import { SchedulingService } from './shared/scheduling.service';
import { RoomService } from '../rooms/shared/room.service';
import { SchedulingModel } from './shared/SchedulingModel';
import { FormGroup, FormBuilder, FormControl, Validators } from '@angular/forms';
import { LoadingController } from '@ionic/angular';
import { ToastController } from '@ionic/angular';
import { PeriodModel } from './shared/PeriodModel';
import { AuthService } from './../auth.service';
import { RoomModel } from '../rooms/shared/RoomModel';
import { Router } from '@angular/router';


@Component({
  selector: 'app-scheduling',
  templateUrl: './scheduling.page.html',
  styleUrls: ['./scheduling.page.scss'],
})
export class SchedulingPage implements OnInit {
  
  public room: RoomModel;
  public studio: StudioModel;
  public monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
  public days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  public dateNow = new Date();
  public dateNowString = this.dateNow.toISOString();
  public minDatetime = `${this.dateNow.getFullYear()}-${this.dateNow.getMonth() + 1}-${(this.dateNow.getDate() < 9) ? '0' + this.dateNow.getDate() : this.dateNow.getDate()}`;
  public maxDatetime = `${this.dateNow.getFullYear() + 1}`;
  public dayName = '';
  
  public selectDate: any;
  public selectRadioGroup: any;
  public periods: Array<PeriodModel>;
  public schedulingForm: FormGroup;
  public scheduling: SchedulingModel = new SchedulingModel();
  public dateScheduling: Date = new Date();
  
  constructor(public service: SchedulingService,
              public roomService: RoomService,
              public auth: AuthService,
              public nav: NavController,
              public formBuilder: FormBuilder,
              public toastr: ToastController,
              public loading: LoadingController,
              private router: Router) { }

  ngOnInit() {
    this.getStudioAndRoom();
    this.setDayName(this.dateNow.toString());
    this.loadPeriodsFree(this.dayName, this.minDatetime);
    this.builSchedulingForm(this.minDatetime);
   
  }

  radioGroup(event) {
    this.selectRadioGroup = event.detail;
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

  builSchedulingForm(dateSchedule: string) {
    this.schedulingForm = this.formBuilder.group({
      date_scheduling: new FormControl(dateSchedule, Validators.compose([Validators.required])),
      customer_id: [this.service.userLocalStorage['customer_id']],
      time_period_id: [this.selectRadioGroup],
      comment: new FormControl(null)
    });
  }

  periodHandler(event) {
    this.scheduling.time_period_id = this.selectRadioGroup;
    console.log(this.scheduling.time_period_id);
  }

  loadPeriodsFree(day: string, date: string) {
    this.service.getPeriodsFreeByRoomIdAndDate(this.room.id, day, date)
    .subscribe(
      periods => this.periods = periods
    );
  }

  changeDateSchedule(event) {
    const newDate = event.detail.value.slice(0, 10);
    let day = new Date(event.detail.value).toString();
    day = day.slice(0, 3);
    const newDayName = this.getDayName(day);

    this.builSchedulingForm(newDate);
    this.loadPeriodsFree(newDayName, newDate);
  }

  setDayName(date: string) {
    const day = date.split(' ')[0];

    switch (day) {
      case 'Sun':
        this.dayName = this.days[0];
        break;
      case 'Mon':
        this.dayName = this.days[1];
        break;
      case 'Tue':
        this.dayName = this.days[2];
        break;
      case 'Wed':
        this.dayName = this.days[3];
        break;
      case 'Thu':
        this.dayName = this.days[4];
        break;
      case 'Fri':
        this.dayName = this.days[5];
        break;
      case 'Sat':
        this.dayName = this.days[6];
        break;
    }
  }
  
  getDayName(day: string) {
    switch (day) {
      case 'Sun':
        return this.days[0];
        break;
      case 'Mon':
        return this.days[1];
        break;
      case 'Tue':
        return this.days[2];
        break;
      case 'Wed':
        return this.days[3];
        break;
      case 'Thu':
        return this.days[4];
        break;
      case 'Fri':
        return this.days[5];
        break;
      case 'Sat':
        return this.days[6];
        break;
    }
  }

  getStudioAndRoom() {
    const studioJson = JSON.parse(localStorage.getItem("studioDetails"));
    const roomJson = JSON.parse(localStorage.getItem("roomDetails"));

    this.studio = Object.assign(new StudioModel(), studioJson);
    this.room = Object.assign(new RoomModel(), roomJson);
  }

  toBackRoomDetails() {
    this.router.navigate([this.room.studio_id, 'rooms', this.room.id, 'details']);
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
