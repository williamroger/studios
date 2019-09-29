import { Component, OnInit } from '@angular/core';

import { AuthService } from './../../../auth.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  studioHasCityId: boolean;

  constructor(private authService: AuthService) { }

  ngOnInit() {
    this.studioHasCityId = (this.authService.userLoggedIn['city_id']) ? true : false;
  }
}
