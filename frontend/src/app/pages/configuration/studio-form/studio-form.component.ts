import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

import { ConfigurationService } from './../shared/configuration.service';
import { CityModel } from '../shared/city.mode';
import { StudioModel } from './../shared/studio.model';

@Component({
  selector: 'app-studio-form',
  templateUrl: './studio-form.component.html',
  styleUrls: ['./studio-form.component.scss']
})
export class StudioFormComponent implements OnInit {

  configForm: FormGroup;
  cities: Array<CityModel>;
  studio: StudioModel = new StudioModel();

  constructor(private configService: ConfigurationService,
              private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.loadCities();
    this.buildConfigForm();
    this.configService.getStudioById()
      .subscribe(
        studio => {
          this.studio = studio['studio']
        }
      );
  }

  // Methods Private
  private loadCities() {
    this.configService.getCitiesByStateId()
      .subscribe(
        cities => this.cities = cities
      );
  }

  private buildConfigForm() {
    this.configForm = this.formBuilder.group({
      name: [this.studio.name, [Validators.required, Validators.minLength(2)]],
      phone: [null],
      description: [null, [Validators.required, Validators.minLength(100)]],
      cnpj: [null],
      telephone: [null],
      email: [null, [Validators.required, Validators.minLength(20)]],
      has_parking: [null, [Validators.required]],
      is_24_hours: [null, [Validators.required]],
      city_id: [null, [Validators.required]],
      zip_code: [null, [Validators.required, Validators.minLength(10)]],
      street: [null, [Validators.required, Validators.minLength(10)]],
      complement: [null],
      district: [null, [Validators.required, Validators.minLength(5)]],
      number: [null, [Validators.required, Validators.minLength(2)]]
    });
  }
}
