import { Component, OnInit} from '@angular/core';
import { NavController, BooleanValueAccessor } from '@ionic/angular';
import { HomeService } from './shared/home.service';
import { StudioModel } from './shared/StudioModel';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {

  public userLoggedIn: any;
  public customerHasCityId: boolean;

  public cityId: number;
  public hasStudios: boolean;
  public studiosMessage = '';
  public studios: Array<StudioModel>;
  
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
      (studios) => {
        if (typeof studios[0] == "object") {
          this.hasStudios = true;
          this.studios = studios;
        } else {
          this.hasStudios = false;
          this.studiosMessage = studios[0].toString();
        }
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
 