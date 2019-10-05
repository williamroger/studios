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
  idPeriod: number;
  roomId: number;

  constructor(private roomService: RoomsService,
              private route: ActivatedRoute,
              private router: Router,
              private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.setCurrentAction();
    this.buildPeriodForm();
    this.loadPeriod();
  }

  submitForm() {
    this.submittingForm = true;

    if (this.currentAction == 'new')
      this.createPeriod();
    else
      this.updatePeriod();
  }

  // Private Methods
  private setCurrentAction() {
    if (this.route.snapshot.url[2].path == 'new'){
      this.currentAction = 'new';
      this.roomId = +this.route.snapshot.url[0].path;
    } else {
      this.currentAction = 'edit';
    }
  }

  private buildPeriodForm() {
    this.periodForm = this.formBuilder.group({
      id: [null],
      room_id: [this.roomId],
      amount: [null, [Validators.required, Validators.minLength(5)]],
      day: [null, [Validators.required]],
      price_rate: [null],
      begin_period: [null, [Validators.required, Validators.minLength(8)]],
      end_period: [null, [Validators.required, Validators.minLength(8)]]
    });
  }

  private loadPeriod() {
    if (this.currentAction == "edit") {
      this.route.paramMap.pipe(
        switchMap(params => this.roomService.getPeriodById(+params.get("idperiod")))
      )
      .subscribe(
        (period) => {
          this.period = period[0];
          this.idPeriod = period[0]['id'];
          this.periodForm.patchValue(period[0])
        },
        (error) => alert("Ocorreu um erro no servidor, tente mais tarde.")
      )
    }
  }

  private createPeriod() {
    const period: PeriodModel = Object.assign(new PeriodModel(), this.periodForm.value);

    this.roomService.createPeriod(period)
      .subscribe(
        period => this.actionsForSuccess(period, 'Período cadastrado com sucesso!'),
        error => this.actionsForError(error)
      );
  }

  private updatePeriod() {
    const period: PeriodModel = Object.assign(new PeriodModel(), this.periodForm.value);

    this.roomService.updatePeriod(period)
      .subscribe(
        period => this.actionsForSuccess(period, 'Período atualizado com sucesso!'),
        error => this.actionsForError(error)
      );
  }

  private actionsForSuccess(period: PeriodModel, message: string) {
    toastr.success(message);
    this.submittingForm = false;

    // redirect / reload / component page
    if (this.currentAction == 'new') {
      setTimeout(() => {
        this.router.navigateByUrl('/salas');
      }, 3000)
    } else {
      this.router.navigateByUrl('periodos', { skipLocationChange: true }).then(
        () => this.router.navigate(['periodos', period.id, 'edit'])
      );
    }
  }

  private actionsForError(error) {
    toastr.error('Ocorreu um erro na aplicação, tento novamente!');

    this.submittingForm = false;

    if (error.status === 422)
      this.serverErrorMessage = JSON.parse(error._body).errors;
    else
      this.serverErrorMessage = ['Falha na comunicação com o servidor. Por favor, tente mais tarde.'];
  }
}
