import { Component, OnInit } from '@angular/core';
import { SchedulingService } from '../scheduling/shared/scheduling.service';
import { AuthService } from './../auth.service';
import { SchedulingModel } from '../scheduling/shared/SchedulingModel';

@Component({
  selector: 'app-tab2',
  templateUrl: 'tab2.page.html',
  styleUrls: ['tab2.page.scss']
})
export class Tab2Page {

  mySchedulings: Array<SchedulingModel>;

  constructor(public service: SchedulingService, public auth: AuthService) {  }

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
