import { CityModel } from './../account/shared/CityModel';
import { Component, OnInit} from '@angular/core';
import { NavController} from '@ionic/angular';
import { HomeService } from './shared/home.service';
import {StudioModel} from './shared/StudioModel';
import { ActivatedRoute, Router } from '@angular/router';
import { RoomService } from '../rooms/shared/room.service';
import { AuthService } from '../login/shared/auth.service';


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
    private router: Router,) { }

  getStudios() {
    this.service.getStudios().subscribe(
      studios => {
        console.log('studios', studios);
        this.studios = studios;
      }
    );
  }

  getStudiosByCityCustomerId() {
    this.service.getStudiosByCityIdCustomer().subscribe(
      studios => {
        console.log('studios', studios);
        this.studios = studios;
      }
    );
  }

  ngOnInit() {
    // tslint:disable-next-line:no-conditional-assignment
    /*if (this.customerHasCityId = (this.auth.userLoggedIn['city_id'])){
      this.getStudios();
    }*/
    this.cityId = this.auth.userLoggedIn['city_id'];
    //if(this.cityId != null){
    //this.getStudiosByCityCustomerId();
    this.getStudios();
  }

  async chamarSala(index){
    this.navCtrl.navigateRoot('room');
    this.service.takeIndex(this.studios[index]);
    //console.log(this.studios[index].id);   
  }

  rotaAccount() {
    this.navCtrl.navigateRoot('tabs/tabs/account');
  }
}
 