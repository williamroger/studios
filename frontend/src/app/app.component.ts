import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/auth.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'frontend';
  showMenu: boolean = false;

  constructor(private authService: AuthService) {}

  ngOnInit() {
    this.loadShowMenu();
  }

  private loadShowMenu() {
    this.showMenu = JSON.parse(localStorage.getItem('loggedIn'));
  }
}
