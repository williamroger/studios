import { Component, OnInit } from '@angular/core';

import { SchedulingService } from '../shared/scheduling.service';
import { ScheduleModel } from '../shared/schedule.model';

import toastr from 'toastr';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  userLoggedIn: any;
  studioHasCityId: boolean;
  schedules: ScheduleModel[] = [];
  schedulesFixed: ScheduleModel[] = [];
  monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
  days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  dateNow = new Date();
  dateNowString = this.dateNow.toISOString();
  minDatetime = `${this.dateNow.getFullYear()}-${this.dateNow.getMonth() + 1}-${(this.dateNow.getDate() < 9) ? '0'+this.dateNow.getDate() : this.dateNow.getDate()}`;
  maxDatetime = `${this.dateNow.getFullYear() + 1}`;
  today = `${(this.dateNow.getDate() < 9) ? '0' + this.dateNow.getDate() : this.dateNow.getDate()} de ${this.getMonthName(this.dateNow.getMonth())} de ${this.dateNow.getFullYear()}`;
  dateSelected = `${(this.dateNow.getDate() < 9) ? '0' + this.dateNow.getDate() : this.dateNow.getDate()} de ${this.getMonthName(this.dateNow.getMonth())} de ${this.dateNow.getFullYear()}`;
  hasSchedules: boolean;
  hasSchedulesFixed: boolean;
  scheduleMessageFixed = '';
  scheduleMessage = '';
  dateScheduling = '';

  ptBR = {
    firstDayOfWeek: 0,
    dayNames: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
    dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
    dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
    monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
    today: 'Hoje',
    clear: 'Limpar',
    dateFormat: 'mm/dd/yy',
    weekHeader: 'Wk'
  }

  constructor(private schedulesService: SchedulingService) { }

  ngOnInit() {
    this.loadCityId();
    this.getSchedules(this.userLoggedIn.studio_id, this.minDatetime);
    this.getSchedulesFixed(this.userLoggedIn.studio_id, this.minDatetime);

    this.dateScheduling = `${this.dateNow.getMonth() + 1}/${ (this.dateNow.getDate() < 9) ? '0' + this.dateNow.getDate() : this.dateNow.getDate()}/${this.dateNow.getFullYear()}`;
    console.log('minDatetime ', this.minDatetime);
  }

  private getSchedulesFixed(id: number, date: string) {
    this.schedulesService.getSchedulesByStudioIdAndDate(id, date).subscribe(
      (schedules) => {
        if (typeof schedules[0] == "object") {
          this.schedulesFixed = schedules;
          this.hasSchedulesFixed = true;
        } else {
          this.hasSchedulesFixed = false;
          this.scheduleMessageFixed = schedules[0].toString();
        }
      }
    )
  }

  private getSchedules(id: number, date: string) {
    this.schedulesService.getSchedulesByStudioIdAndDate(id, date).subscribe(
      (schedules) =>  {
        if (typeof schedules[0] == "object") {
          this.schedules = schedules;
          this.hasSchedules = true;
        } else {
          this.hasSchedules = false;
          this.scheduleMessage = schedules[0].toString();
        }
      }
    )
  }

  private confirmScheduling(schedule) {
    const sched: ScheduleModel = Object.assign(new ScheduleModel(), schedule);
    const confirmation = confirm('Deseja realmente CONFIRMAR este agendamento?');

    if (confirmation) {
      this.schedulesService.confirmScheduling(sched).subscribe(
        (message) => {
          this.actionsForSuccess(message);
        },
        (error) => {
          if (error.error.text.indexOf('{"success":true') == 0) {
            this.actionsForSuccess('Agendamento confirmado com sucesso!');
          } else {
            this.actionsForError(error);
          }
        }
      );
    }
  }

  private cancelScheduling(schedule) {
    const sched: ScheduleModel = Object.assign(new ScheduleModel(), schedule);
    const cancellation = confirm('Deseja realmente CANCELAR este agendamento?');

    if (cancellation) {
      this.schedulesService.cancelScheduling(sched).subscribe(
        (message) => {
          this.actionsForSuccess(message);
        },
        (error) => {
          if (error.error.text.indexOf('{"success":true') == 0) {
            this.actionsForSuccess('Agendamento cancelado com sucesso!');
          } else {
            this.actionsForError(error);
          }
        }
      );
    }
  }

  private loadCityId() {
    this.userLoggedIn = JSON.parse(localStorage.getItem('userLoggedIn'));
    this.studioHasCityId = (+this.userLoggedIn['city_id']) ? true : false;
  }

  private toggleDetails(event) {
    let target = event.currentTarget;
    let icon = target.querySelector('.icon');
    let details = target.closest('.schedule').querySelector('.schedule__body');
    if (details.classList.contains('d-none')) {
      details.classList.remove('d-none');
      icon.classList.remove('pi-chevron-down');
      icon.classList.add('pi-chevron-up');
    } else {
      details.classList.add('d-none');
      icon.classList.remove('pi-chevron-up');
      icon.classList.add('pi-chevron-down');
    }
  }

  private getMonthName(month: number) {
    switch (month) {
      case 0:
        return this.monthNames[0];
        break;
      case 1:
        return this.monthNames[1];
        break;
      case 2:
        return this.monthNames[2];
        break;
      case 3:
        return this.monthNames[3];
        break;
      case 4:
        return this.monthNames[4];
        break;
      case 5:
        return this.monthNames[5];
        break;
      case 6:
        return this.monthNames[6];
        break;
      case 7:
        return this.monthNames[7];
        break;
      case 8:
        return this.monthNames[8];
        break;
      case 9:
        return this.monthNames[9];
        break;
      case 10:
        return this.monthNames[10];
        break;
      case 11:
        return this.monthNames[11];
        break;
    }
  }

  private getMonthNameString(month: string): string {
    switch (month) {
      case 'Jan':
        return this.monthNames[0];;
        break;
      case 'Feb':
        return this.monthNames[1];;
        break;
      case 'Mar':
        return this.monthNames[2];;
        break;
      case 'Apr':
        return this.monthNames[3];;
        break;
      case 'May':
        return this.monthNames[4];;
        break;
      case 'Jun':
        return this.monthNames[5];;
        break;
      case 'Jul':
        return this.monthNames[6];;
        break;
      case 'Aug':
        return this.monthNames[7];;
        break;
      case 'Sep':
        return this.monthNames[8];;
        break;
      case 'Oct':
        return this.monthNames[9];;
        break;
      case 'Nov':
        return this.monthNames[10];;
        break;
      case 'Dec':
        return this.monthNames[11];;
        break;
    }
  }

  private actionsForSuccess(message: string) {
    toastr.success(message);
    setTimeout(() => {
      window.location.reload();
    }, 3000);
  }

  private actionsForError(error) {
    toastr.error('Ocorreu um erro na aplicação, tento novamente!');
    setTimeout(() => {
      window.location.reload();
    }, 3000);
  }

  public changeDateScheduling(event: any) {
    const date = event.toString();
    let monthString = date.slice(4, 7);
    let month = this.getMonthNumber(monthString);
    let day = date.slice(8, 10);
    let year = date.slice(11, 15);
    const newDate = `${year}-${month}-${day}`;

    this.getSchedules(this.userLoggedIn.studio_id, newDate);
    this.dateSelected = `${day} de ${this.getMonthNameString(monthString)} de ${year}`;
  }

  public getMonthNumber(month: string): string {
    switch(month) {
      case 'Jan':
        return '01';
        break;
      case 'Feb':
        return '02';
        break;
      case 'Mar':
        return '03';
        break;
      case 'Apr':
        return '04';
        break;
      case 'May':
        return '05';
        break;
      case 'Jun':
        return '06';
        break;
      case 'Jul':
        return '07';
        break;
      case 'Aug':
        return '08';
        break;
      case 'Sep':
        return '09';
        break;
      case 'Oct':
        return '10';
        break;
      case 'Nov':
        return '11';
        break;
      case 'Dec':
        return '12';
        break;
    }
  }
}
