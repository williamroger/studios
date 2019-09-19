import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

import { StudioModel } from '../shared/studio.model';
import { RegisterService } from '../shared/register.service';

@Component({
  selector: 'app-studio-form',
  templateUrl: './studio-form.component.html',
  styleUrls: ['./studio-form.component.scss']
})
export class StudioFormComponent implements OnInit {

  studioForm: FormGroup;
  submittingForm: boolean = false;
  studio: StudioModel = new StudioModel();

  constructor(
    private registerService: RegisterService,
    private formBuilder: FormBuilder
  ) { }

  ngOnInit() {
    this.buildStudioForm();
  }

  // Private Methods
  buildStudioForm() {
    this.studioForm = this.formBuilder.group({
      name: [null, [Validators.required, Validators.minLength(4)]],
      email: [null, [Validators.required, Validators.minLength(10)]],
      password: [null, [Validators.required, Validators.minLength(6)]]
    })
  }
}
