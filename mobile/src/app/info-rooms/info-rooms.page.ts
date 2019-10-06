import { Component, OnInit } from '@angular/core';
import { RoomService } from '../rooms/shared/room.service';
import { RoomModel } from '../rooms/shared/RoomModel';
import { NavController} from '@ionic/angular';


@Component({
  selector: 'app-info-rooms',
  templateUrl: './info-rooms.page.html',
  styleUrls: ['./info-rooms.page.scss'],
})
export class InfoRoomsPage implements OnInit {

  public room: RoomModel;

  constructor(public serviceRoom: RoomService,
    public navCtrl: NavController) { }

  ngOnInit() {
    this.room = this.serviceRoom.getRoom();
  }

  voltar(){
    this.navCtrl.navigateRoot('room');
  }

}
