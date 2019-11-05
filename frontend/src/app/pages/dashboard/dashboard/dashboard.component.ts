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

  constructor(private schedulesService: SchedulingService) { }

  ngOnInit() {
    this.loadCityId();
    this.getSchedules();
  }

  private getSchedules() {
    this.schedulesService.getSchedulesByStudioIdAndDate(1, '2019-10-08').subscribe(
      schedules => this.schedules = schedules
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
