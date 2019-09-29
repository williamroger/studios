import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

import { ConfigurationService } from './../shared/configuration.service';
import { CityModel } from '../shared/city.mode';

@Component({
  selector: 'app-studio-form',
  templateUrl: './studio-form.component.html',
  styleUrls: ['./studio-form.component.scss']
})
export class StudioFormComponent implements OnInit {

  configForm: FormGroup;
  cities: Array<CityModel>;

  constructor(private configService: ConfigurationService) { }

  ngOnInit() {
    this.loadCities();
  }

  // Methods Private
  private loadCities() {
    this.configService.getCitiesByStateId()
      .subscribe(
        cities => {
          console.log('cities ', cities);
          this.cities = cities
        }
      );
  }
}
