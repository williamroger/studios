import { Component, OnInit} from '@angular/core';
import { Router, NavigationExtras } from '@angular/router';
import { NavController, ToastController} from '@ionic/angular';
import { HomeService } from './shared/home.service';
import {StudioModel} from './shared/StudioModel';

@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {

  public studios: Array<StudioModel>;

  constructor(public navCtrl: NavController,  
    public service:HomeService,
    private router: Router) { }

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

  chamarSala(index){
    this.navCtrl.navigateRoot('room');
    console.log(index);
  }
}
 