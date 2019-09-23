import { ConfigurationService } from './../shared/configuration.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-studio-form',
  templateUrl: './studio-form.component.html',
  styleUrls: ['./studio-form.component.scss']
})
export class StudioFormComponent implements OnInit {

  states: [] = [];

  constructor(private configService: ConfigurationService) { }

  ngOnInit() {
    this.configService.getAllStates()
      .subscribe(data => console.log('data ', data));
  }

}
