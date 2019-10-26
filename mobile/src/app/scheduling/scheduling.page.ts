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
  public periods: Array<PeriodModel>;
  public schedulingForm: FormGroup;
  public room: RoomModel;
  public period: PeriodModel = new PeriodModel();
  public scheduling: SchedulingModel = new SchedulingModel();
  dateScheduling: Date = new Date();
  monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
  dateNow = new Date();
  dateNowString = this.dateNow.toISOString();
  minDatetime = `${this.dateNow.getFullYear()}-${this.dateNow.getMonth()+1}-${this.dateNow.getDate()}`;
  maxDatetime = `${this.dateNow.getFullYear()+1}`;
  dayName = '';
  days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

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
    console.log('dateNow ', this.dateNow);
    console.log('dateNowString ', this.dateNowString);
    this.setDayName(this.dateNow.toString());
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
      //id: [null],
      date_scheduling: new FormControl(Date),
      customer_id: [this.service.userLocalStorage['customer_id']],
      time_period_id: [this.selectRadioGroup],
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

  // Change Datetime
  changeDateSchedule(event) {
    console.log('changeDate ', event);
    console.log('Date ', new Date(event.detail.value))
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

    console.log('dayName ', this.dayName);

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
