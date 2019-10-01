import { Component, OnInit } from '@angular/core';
import { RoomsService } from '../shared/rooms.service';
import { RoomModel } from '../shared/room.model';

@Component({
  selector: 'app-room-list',
  templateUrl: './room-list.component.html',
  styleUrls: ['./room-list.component.scss']
})
export class RoomListComponent implements OnInit {

  rooms: Array<RoomModel> = [];

  constructor(private roomsService: RoomsService) { }

  ngOnInit() {
    this.roomsService.getRoomsByStudioId().subscribe(
      rooms => this.rooms = rooms
    )
  }

}
