import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  userLoggedIn: any;
  studioHasCityId: boolean;

  constructor() { }

  ngOnInit() {
    this.loadCityId();
  }

  private loadCityId() {
    this.userLoggedIn = JSON.parse(localStorage.getItem('userLoggedIn'));
    this.studioHasCityId = (+this.userLoggedIn['city_id']) ? true : false;
  }
}
