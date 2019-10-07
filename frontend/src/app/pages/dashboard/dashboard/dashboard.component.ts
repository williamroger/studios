import { Component, OnInit } from '@angular/core';

import { AuthService } from './../../../auth.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  userLoggedIn: any;
  studioHasCityId: boolean;

  constructor(private authService: AuthService) { }

  ngOnInit() {
    this.loadCityId();
  }

  private loadCityId() {
    this.userLoggedIn = JSON.parse(localStorage.getItem('userLoggedIn'));
    this.studioHasCityId = (+this.userLoggedIn['city_id']) ? true : false;
  }
}
