import { PeriodModel } from './../shared/period.model';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

import { RoomsService } from './../shared/rooms.service';

@Component({
  selector: 'app-period-list',
  templateUrl: './period-list.component.html',
  styleUrls: ['./period-list.component.scss']
})
export class PeriodListComponent implements OnInit {

  periods: Array<PeriodModel> = [];

  constructor(private roomService: RoomsService,
              private route: ActivatedRoute) { }

  ngOnInit() {
    this.loadPeriods();
  }

  loadPeriods() {
    const id = this.route.snapshot.url[0].path;

    this.roomService.getPeriodsByRoomId(+id).subscribe(
      periods => this.periods = periods
    )
  }
}
