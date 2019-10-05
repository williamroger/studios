import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { RoomsService } from '../shared/rooms.service';
import { RoomModel } from '../shared/room.model';

import toastr from 'toastr';

@Component({
  selector: 'app-room-list',
  templateUrl: './room-list.component.html',
  styleUrls: ['./room-list.component.scss']
})
export class RoomListComponent implements OnInit {

  rooms: Array<RoomModel> = [];

  constructor(private roomsService: RoomsService,
              private router: Router) { }

  ngOnInit() {
    this.loadRooms();
  }

  loadRooms() {
    this.roomsService.getRoomsByStudioId().subscribe(
      rooms => this.rooms = rooms
    )
  }

  goToPeriods(room) {
    this.router.navigate(['salas', room.id, 'periodos']);
    localStorage.setItem('roomName', JSON.stringify(room.name));
  }

  deleteRoom(room) {
    const confirmDelete = confirm('Deseja realmente excluir esta sala?');

    if (confirmDelete) {
      this.roomsService.delete(room.id).subscribe(
        (data) => {
          toastr.success(data.msg);
          this.loadRooms();
        }
      )
    }
  }
}
