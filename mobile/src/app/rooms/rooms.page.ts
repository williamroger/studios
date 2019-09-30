import { RoomService } from './shared/room.service';
import { RoomModel } from './shared/RoomModel';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-rooms',
  templateUrl: './rooms.page.html',
  styleUrls: ['./rooms.page.scss'],
})
export class RoomsPage implements OnInit {

  public rooms: Array<RoomModel>;

  constructor(public service: RoomService) { }

  ngOnInit() {
    this.getRooms();
    //this.getRoomsByStudio();
  }

  getRooms() {
    this.service.getRooms().subscribe(
      rooms => {
        console.log('rooms', rooms);
        this.rooms = rooms;
      }
    );
  }

  getRoomsByStudio() {
    this.service.getRoomsByStudio().subscribe(
      rooms => {
        console.log('rooms', rooms);
        this.rooms = rooms;
      }
    );
  }
}