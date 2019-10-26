import { CityModel } from './../account/shared/CityModel';
import { Component, OnInit} from '@angular/core';
import { NavController } from '@ionic/angular';
import { HomeService } from './shared/home.service';
import { StudioModel } from './shared/StudioModel';
import { ActivatedRoute, Router } from '@angular/router';
import { RoomService } from '../rooms/shared/room.service';
import { AuthService } from './../auth.service';


@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {

  public customerHasCityId: boolean;
  public city: CityModel = new CityModel();
  public cityId: number;
  public studios: Array<StudioModel>;
  public API_URL = 'http://localhost:8080/';

  constructor(public navCtrl: NavController,  
    public service:HomeService,
    public serviceRoom:RoomService,
    public auth: AuthService,
    private route: ActivatedRoute,
    private router: Router) { }

  ngOnInit() {
    this.cityId = this.auth.userLoggedIn['city_id'];
    if (this.cityId != null) {
      this.getStudiosByCityCustomerId();
    }
  }

  ionRefresh(event) {
    console.log('Pull Event Triggered!');
    setTimeout(() => {
      console.log('Async operation has ended');
      this.ionViewWillEnter();
      event.target.complete();
    }, 2000);
  }

  async ionViewWillEnter() {}

  getStudiosByCityCustomerId() {
    this.service.getStudiosByCityIdCustomer().subscribe(
      studios => {
        this.studios = studios;
      }
    );
  }

  async chamarSala(index){
    this.navCtrl.navigateRoot('rooms');
    this.service.takeIndex(this.studios[index]);
    //console.log(this.studios[index].id);   
  }

  rotaAccount() {
    this.navCtrl.navigateRoot('tabs/tabs/account');
  }
}
 