import { StudioModel } from './../home/shared/StudioModel';
import { Component, OnInit } from '@angular/core';
import { SchedulingService } from './shared/scheduling.service';
import { RoomService } from '../rooms/shared/room.service';
import { SchedulingModel } from './shared/SchedulingModel';
import { FormGroup, FormBuilder, FormControl, Validators } from '@angular/forms';
import { LoadingController } from '@ionic/angular';
import { ToastController } from '@ionic/angular';
import { PeriodModel } from './shared/PeriodModel';
import { RoomModel } from '../rooms/shared/RoomModel';
import { Router } from '@angular/router';
import { CustomerModel } from '../account/shared/customerModel';


@Component({
  selector: 'app-scheduling',
  templateUrl: './scheduling.page.html',
  styleUrls: ['./scheduling.page.scss'],
})
export class SchedulingPage implements OnInit {
  
  public room: RoomModel;
  public studio: StudioModel;
  public customer: CustomerModel;
  public monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
  public days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  public dateNow = new Date();
  public dateNowString = this.dateNow.toISOString();
  public minDatetime = `${this.dateNow.getFullYear()}-${this.dateNow.getMonth() + 1}-${(this.dateNow.getDate() < 9) ? '0' + this.dateNow.getDate() : this.dateNow.getDate()}`;
  public maxDatetime = `${this.dateNow.getFullYear() + 1}`;
  public dayName = '';
  public newDate = this.minDatetime;

  public hasPeriods: boolean;
  public messagePeriods = '';
  public periodId = '';
  public selectedRadioItem: any;
  public periods: Array<PeriodModel>;
  public schedulingForm: FormGroup;
  public scheduling: SchedulingModel = new SchedulingModel();
  public dateScheduling: Date = new Date();
  
  constructor(public service: SchedulingService,
              public roomService: RoomService,
              public formBuilder: FormBuilder,
              public toastr: ToastController,
              public loading: LoadingController,
              private router: Router) { }

  ngOnInit() {
    this.getCustomerStudioRoom();
    this.setDayName(this.dateNow.toString());
    this.loadPeriodsFree(this.dayName, this.minDatetime);
    this.builSchedulingForm(this.minDatetime);
  }

  submitForm() {
    const scheduling: SchedulingModel = Object.assign(new SchedulingModel(), this.schedulingForm.value);
    this.presentLoading();
    
    this.service.insertScheduling(this.schedulingForm.value)
    .subscribe(
      studio => this.actionsForSuccess(this.schedulingForm.value),
      error => this.actionsForError(error)
    )
  }

  builSchedulingForm(dateSchedule?: string, periodId?: string) {
    this.schedulingForm = this.formBuilder.group({
      date_scheduling: new FormControl(dateSchedule, Validators.compose([Validators.required])),
      customer_id: [this.customer.customer_id, Validators.compose([Validators.required])],
      time_period_id: new FormControl(periodId, Validators.compose([Validators.required])),
      comment: new FormControl(null)
    });
  }

  loadPeriodsFree(day: string, date: string) {
    this.service.getPeriodsFreeByRoomIdAndDate(this.room.id, day, date)
    .subscribe(
      (periods) => {
        if (typeof periods[0] == "object") {
          this.hasPeriods = true;
          this.periods = periods
        } else {
          this.hasPeriods = false;
          this.messagePeriods = periods[0].toString();
        }
      } 
    );
  }

  changeDateSchedule(event) {
    const newDate = event.detail.value.slice(0, 10);
    let day = new Date(event.detail.value).toString();
    day = day.slice(0, 3);
    const newDayName = this.getDayName(day);

    this.newDate = newDate;
    this.builSchedulingForm(newDate);
    this.loadPeriodsFree(newDayName, newDate);
  }

  checkedTimePeriod(periodId: string) {
    const date = this.newDate;
    const cards = document.querySelectorAll('.card-period');
    const target = document.getElementById(periodId);

    cards.forEach((item) => {
      item.classList.remove('card-period-checked');
    });

    target.classList.add('card-period-checked');
    
    this.builSchedulingForm(date, periodId);
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

  getCustomerStudioRoom() {
    const userJson = JSON.parse(localStorage.getItem("userLoggedIn"));
    const studioJson = JSON.parse(localStorage.getItem("studioDetails"));
    const roomJson = JSON.parse(localStorage.getItem("roomDetails"));

    this.customer = Object.assign(new CustomerModel(), userJson);
    this.studio = Object.assign(new StudioModel(), studioJson);
    this.room = Object.assign(new RoomModel(), roomJson);
  }

  toBackRoomDetails() {
    this.router.navigate([this.room.studio_id, 'rooms', this.room.id, 'details']);
  }

  async presentLoading() {
    const loading = await this.loading.create({
      message: 'Aguarde...',
      duration: 1000
    });
    await loading.present();

    const { role, data } = await loading.onDidDismiss();
  }

  async presentToast(message: string) {
    const toast = await this.toastr.create({
      message,
      duration: 2000,
      color: 'secondary'
    });
    toast.present();
  }

  actionsForSuccess(scheduling: SchedulingModel) {
    this.presentToast('Ensaio agendado com sucesso!');
    setTimeout(() => {
      this.router.navigate(['tabs', 'schedules']);
    }, 3000);
  }

  actionsForError(error) {
    this.presentToast('Ocorreu um erro, tente novamente!');
  }
}
