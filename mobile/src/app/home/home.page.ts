import { Component, OnInit} from '@angular/core';
import { NavController } from '@ionic/angular';
import { HomeService } from './shared/home.service';
import { StudioModel } from './shared/StudioModel';
import { RoomService } from '../rooms/shared/room.service';
import { AuthService } from './../auth.service';


@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {

  userLoggedIn: any;
  customerHasCityId: boolean;

  cityId: number;
  studios: Array<StudioModel> = [];

  constructor(public navCtrl: NavController,  
    public homeService: HomeService,
    public serviceRoom: RoomService,
    public auth: AuthService) { }

  ngOnInit() {
    this.loadCityId();
    if (this.customerHasCityId) {
      this.getStudiosByCityIdCustomer();
    }
  }

  private loadCityId() {
    this.userLoggedIn = JSON.parse(localStorage.getItem('userLoggedIn'));
    this.customerHasCityId = (+this.userLoggedIn.city_id) ? true : false;
    this.cityId = +this.userLoggedIn.city_id;
  }

  private getStudiosByCityIdCustomer() {
    this.homeService.getStudiosByCityIdCustomer().subscribe(
      studios => {
        this.studios = studios;
      }
    );
  }

  async chamarSala(index){
    this.navCtrl.navigateRoot('rooms');
    this.homeService.takeIndex(this.studios[index]);
    //console.log(this.studios[index].id);   
  }

  routeAccount() {
    this.navCtrl.navigateRoot('tabs/account');
  }
}
 