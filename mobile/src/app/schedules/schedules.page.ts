import { SchedulesService } from './shared/schedules.service';
import { Component, OnInit } from '@angular/core';
import { ScheduleModel } from './shared/scheduleModel';

@Component({
  selector: 'app-schedules',
  templateUrl: './schedules.page.html',
  styleUrls: ['./schedules.page.scss'],
})
export class SchedulesPage implements OnInit {

  public schedules: Array<ScheduleModel>; 
  public hasSchedules: boolean;
  public schedulesMessage = '';

  constructor(public schedulesService: SchedulesService) { }

  // tslint:disable-next-line:use-lifecycle-interface
  ngOnInit() {
    this.getSchedules();
  }

  getSchedules() {
    this.schedulesService.getSchedulesByCustomer().subscribe(
      (schedules) => {
        if (typeof schedules[0] == "object") {
          this.hasSchedules = true;
          this.schedules = schedules;
        } else {
          this.hasSchedules = false;
          this.schedulesMessage = schedules[0].toString();
        }
      }
    );
  }

}
