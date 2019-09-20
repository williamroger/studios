import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-studio-form-update',
  templateUrl: './studio-form-update.component.html',
  styleUrls: ['./studio-form-update.component.scss']
})
export class StudioFormUpdateComponent implements OnInit {
  studioForm: FormGroup;

  constructor() { }

  ngOnInit() {
  }

}
