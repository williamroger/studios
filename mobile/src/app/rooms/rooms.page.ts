import { RoomService } from './shared/room.service';
import { RoomModel } from './shared/RoomModel';
import { Component, OnInit } from '@angular/core';
import { HomeService } from '../home/shared/home.service';

@Component({
  selector: 'app-rooms',
  templateUrl: './rooms.page.html',
  styleUrls: ['./rooms.page.scss'],
})
export class RoomsPage implements OnInit {

  public rooms: Array<RoomModel> = [];

  public id;

  constructor(public service: RoomService,
    public serviceHome: HomeService) {}

  ngOnInit() {
    //this.getRooms();
    this.id = this.serviceHome.returnIndex();
    this.getRoomsByStudio(this.id);
  }

  getRooms() {
    this.service.getRooms().subscribe(
      rooms => {
        console.log('rooms', rooms);
        this.rooms = rooms;
      }
    );
  }

  getRoomsByStudio(id: number){
    this.service.getRoomsByStudio(id).subscribe(
      rooms => this.rooms = rooms
    )
  }
}