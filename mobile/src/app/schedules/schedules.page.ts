import { Component, OnInit } from '@angular/core';
import { SchedulingModel } from '../scheduling/shared/SchedulingModel';
import { SchedulingService } from '../scheduling/shared/scheduling.service';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-schedules',
  templateUrl: './schedules.page.html',
  styleUrls: ['./schedules.page.scss'],
})
export class SchedulesPage implements OnInit {

  mySchedulings: Array<SchedulingModel>;

  constructor(public service: SchedulingService, public auth: AuthService) { }

  // tslint:disable-next-line:use-lifecycle-interface
  ngOnInit() {
    this.getMySchedulings();
  }

  getMySchedulings() {
    this.service.getSchedulingByCustomer().subscribe(
      schedules => {
        console.log('schedules', schedules);
        this.mySchedulings = schedules;
      }
    );
  }

}
