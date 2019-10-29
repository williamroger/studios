import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { RoomService } from './shared/room.service';
import { RoomModel } from './shared/RoomModel';
import { StudioModel } from '../home/shared/StudioModel';

@Component({
  selector: 'app-rooms',
  templateUrl: './rooms.page.html',
  styleUrls: ['./rooms.page.scss'],
})
export class RoomsPage implements OnInit {

  public rooms: Array<RoomModel> = [];
  public studio: StudioModel;

  constructor(private service: RoomService,
              private router: Router) {}

  ngOnInit() {
    this.getStudio();
    this.getRoomsByStudioID(this.studio.id);
  }

  getRoomsByStudioID(id: number){
    this.service.getRoomsByStudioID(id).subscribe(
      rooms => this.rooms = rooms
    )
  }

  getStudio() {
    const studioJson = JSON.parse(localStorage.getItem('studioDetails'));
    this.studio = Object.assign(new StudioModel(), studioJson);
  }

  toBackStudios() {
    localStorage.removeItem('studioDetails');
    this.router.navigate(['tabs/studios']);
  }

  goToRoomDetails(room: RoomModel) {
    this.router.navigate([room.studio_id, 'rooms', room.id, 'details']);
    localStorage.setItem('roomDetails', JSON.stringify(room));
  }
}