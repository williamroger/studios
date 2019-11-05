import { Component, OnInit } from '@angular/core';

import { SchedulingService } from '../shared/scheduling.service';
import { ScheduleModel } from '../shared/schedule.model';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  userLoggedIn: any;
  studioHasCityId: boolean;
  schedules: ScheduleModel[] = [];
  monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
  days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  dateNow = new Date();
  dateNowString = this.dateNow.toISOString();
  minDatetime = `${this.dateNow.getFullYear()}-${this.dateNow.getMonth() + 1}-${(this.dateNow.getDate() < 9) ? '0'+this.dateNow.getDate() : this.dateNow.getDate()}`;
  maxDatetime = `${this.dateNow.getFullYear() + 1}`;
  day = 'Hoje';
  hasSchedules: boolean;
  scheduleMessage = '';

  constructor(private schedulesService: SchedulingService) { }

  ngOnInit() {
    this.loadCityId();
    this.getSchedules(this.userLoggedIn.studio_id, this.minDatetime);
  }

  private getSchedules(id: number, date: string) {
    this.schedulesService.getSchedulesByStudioIdAndDate(id, date).subscribe(
      (schedules) =>  {
        // Melhorar essa verificação aqui
        if (schedules.length > 1) {
          this.schedules = schedules;
          this.hasSchedules = true;
        } else {
          this.hasSchedules = false;
          this.scheduleMessage = schedules[0].toString();
        }
      }
    )
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
}
