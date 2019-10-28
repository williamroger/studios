import { Component, OnInit} from '@angular/core';
import { NavController } from '@ionic/angular';
import { HomeService } from './shared/home.service';
import { StudioModel } from './shared/StudioModel';
import { Router } from '@angular/router';

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

  constructor(private navCtrl: NavController,  
              private homeService: HomeService,
              private router: Router) { }

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

  goToRooms(studio: StudioModel) {
    this.router.navigate([studio.id, 'rooms']);
    localStorage.setItem('studioDetails', JSON.stringify(studio));
  }

  routeAccount() {
    this.navCtrl.navigateRoot('tabs/account');
  }
}
 