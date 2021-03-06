import { PeriodModel } from './../shared/period.model';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

import { RoomsService } from './../shared/rooms.service';

import toastr from 'toastr';

@Component({
  selector: 'app-period-list',
  templateUrl: './period-list.component.html',
  styleUrls: ['./period-list.component.scss']
})
export class PeriodListComponent implements OnInit {

  periods: PeriodModel[] = [];
  roomName: string;

  constructor(private roomService: RoomsService,
              private route: ActivatedRoute,
              private router: Router) { }

  ngOnInit() {
    this.loadPeriods();
    this.roomName = JSON.parse(localStorage.getItem('roomName'));
  }

  goToRooms() {
    this.router.navigate(['salas']);
    localStorage.removeItem('roomName');
  }

  loadPeriods() {
    const id = this.route.snapshot.url[0].path;

    this.roomService.getPeriodsByRoomId(+id).subscribe(
      periods => this.periods = periods
    )
  }

  deletePeriod(period) {
    const confirmDelete = confirm('Deseja realmente excluir este período?');

    if (confirmDelete) {
      this.roomService.deletePeriod(period.id).subscribe(
        (data) => {
          toastr.success(data.msg);
          this.loadPeriods();
        }
      )
    }
  }
}
