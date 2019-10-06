import { RoomService } from './shared/room.service';
import { RoomModel } from './shared/RoomModel';
import { Component, OnInit } from '@angular/core';
import { HomeService } from '../home/shared/home.service';
import {StudioModel} from '../home/shared/StudioModel';
import { NavController} from '@ionic/angular';

@Component({
  selector: 'app-rooms',
  templateUrl: './rooms.page.html',
  styleUrls: ['./rooms.page.scss'],
})
export class RoomsPage implements OnInit {

  public rooms: Array<RoomModel> = [];
  public studio: StudioModel;

  constructor(public service: RoomService,
    public serviceHome: HomeService,
    public navCtrl: NavController) {}

  ngOnInit() {
    //this.getRooms();
    this.studio = this.serviceHome.returnStudio();
    this.getRoomsByStudio(this.studio);
  }

  getRooms() {
    this.service.getRooms().subscribe(
      rooms => {
        console.log('rooms', rooms);
        this.rooms = rooms;
      }
    );
  }

  getRoomsByStudio(studio: StudioModel){
    this.service.getRoomsByStudio(studio.id).subscribe(
      rooms => this.rooms = rooms
    )
  }

  voltar(){
    this.navCtrl.navigateRoot('tabs/tabs/home');
  }
}