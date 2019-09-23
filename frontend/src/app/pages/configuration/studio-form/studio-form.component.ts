import { ConfigurationService } from './../shared/configuration.service';
import { Component, OnInit } from '@angular/core';

import { StateModel } from '../shared/state.model';

@Component({
  selector: 'app-studio-form',
  templateUrl: './studio-form.component.html',
  styleUrls: ['./studio-form.component.scss']
})
export class StudioFormComponent implements OnInit {

  states: StateModel[] = [];

  constructor(private configService: ConfigurationService) { }

  ngOnInit() {
    this.configService.getAllStates()
      .subscribe(data => this.states = data['data']);
  }

}
