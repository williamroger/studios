import { Component, OnInit} from '@angular/core';
import { NavController} from '@ionic/angular';
import { HomeService } from './shared/home.service';
import {StudioModel} from './shared/StudioModel';
import { ActivatedRoute, Router } from '@angular/router';
import { RoomService } from '../rooms/shared/room.service';


@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {

  public studios: Array<StudioModel>;
  public API_URL = 'http://localhost:8080/';

  constructor(public navCtrl: NavController,  
    public service:HomeService,
    public serviceRoom:RoomService,
    private route: ActivatedRoute,
    private router: Router,) { }

  getStudios() {
    this.service.getStudios().subscribe(
      studios => {
        console.log('studios', studios);
        this.studios = studios;
      }
    );
  }

  ngOnInit() {
    this.getStudios();
  }

  async chamarSala(index){
    this.navCtrl.navigateRoot('room');
    this.service.takeIndex(this.studios[index]);
    //console.log(this.studios[index].id);   
  }
}
 