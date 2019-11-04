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

  private toggleDetails(event) {
    let target = event.currentTarget;
    let icon = target.querySelector('.icon');
    let details = target.closest('.schedule').querySelector('.schedule__body');
    if (details.classList.contains('d-none')) {
      details.classList.remove('d-none');
      icon.classList.remove('pi-chevron-down');
      icon.classList.add('pi-chevron-up');
    } else {
      details.classList.add('d-none');
      icon.classList.remove('pi-chevron-up');
      icon.classList.add('pi-chevron-down');
    }
  }
}
