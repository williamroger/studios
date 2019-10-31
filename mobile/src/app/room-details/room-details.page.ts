import { Router } from '@angular/router';
import { Component, OnInit, ViewChild  } from '@angular/core';

import { RoomModel } from '../rooms/shared/RoomModel';

@Component({
  selector: 'app-room-details',
  templateUrl: './room-details.page.html',
  styleUrls: ['./room-details.page.scss'],
})
export class RoomDetailsPage implements OnInit {

  public room: RoomModel;

  constructor(private router: Router) { }

  ngOnInit() {
    this.getRoom();
  }

  getRoom() {
    const roomJson = JSON.parse(localStorage.getItem('roomDetails'));
    this.room = Object.assign(new RoomModel(), roomJson);
  }

  toBackRooms() {
    localStorage.removeItem('roomDetails');
    this.router.navigate([this.room.studio_id, 'rooms']);
  }

  toScheduling(room: RoomModel) {
    this.router.navigate([room.studio_id, 'rooms', room.id, 'details', 'scheduling']);
  }
}
