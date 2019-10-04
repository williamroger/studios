import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

import { PeriodModel } from './../shared/period.model';

import { switchMap } from 'rxjs/operators';

import toastr from 'toastr';
import { RoomsService } from '../shared/rooms.service';

@Component({
  selector: 'app-period-form',
  templateUrl: './period-form.component.html',
  styleUrls: ['./period-form.component.scss']
})
export class PeriodFormComponent implements OnInit {

  currentAction: string;
  periodForm: FormGroup;
  pageTitle: string;
  serverErrorMessage: string[] = null;
  submittingForm: boolean = false;
  period: PeriodModel = new PeriodModel();

  constructor(private roomService: RoomsService,
              private route: ActivatedRoute,
              private router: Router,
              private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.buildPeriodForm();
  }

  // Private Methods
  private buildPeriodForm() {
    this.periodForm = this.formBuilder.group({
      id: [null],
      room_id: [null],
      amount: [null, [Validators.required, Validators.minLength(5)]],
      day: [null, [Validators.required]],
      price_rate: [null],
      begin_period: [null, [Validators.required, Validators.minLength(8)]],
      end_period: [null, [Validators.required, Validators.minLength(8)]]
    });
  }
}
