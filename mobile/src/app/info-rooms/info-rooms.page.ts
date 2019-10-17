import { Component, OnInit, ViewChild  } from '@angular/core';
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
  mySlider: any;

  constructor(public serviceRoom: RoomService,
    public navCtrl: NavController) { }

  ngOnInit() {
    this.room = this.serviceRoom.getRoom();
  }

  voltar(){
    this.navCtrl.navigateRoot('room');
  }

  rotaScheduling() {
    this.navCtrl.navigateRoot('scheduling');
  }

  salas = [
    {
      "img": "./assets/sala1.jpeg"
    },
    {
      "img": "./assets/sala2.jpeg"
    },
    {
      "img": "./assets/sala3.jpeg"
    },
    
  ]

  slideNext(){
    this.mySlider.slideNext();
  }

  slidePrev(){
    this.mySlider.slidePrev();
  }
}
