import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';

import { StudioModel } from '../shared/studio.model';
import { RegisterService } from '../shared/register.service';

import toastr from 'toastr';

@Component({
  selector: 'app-studio-form',
  templateUrl: './studio-form.component.html',
  styleUrls: ['./studio-form.component.scss']
})
export class StudioFormComponent implements OnInit {

  studioForm: FormGroup;
  serverErrorMessage: string[] = null;
  submittingForm: boolean = false;
  studio: StudioModel = new StudioModel();

  constructor(
    private registerService: RegisterService,
    private formBuilder: FormBuilder,
    private router: Router
  ) { }

  ngOnInit() {
    this.buildStudioForm();
  }

  submitForm() {
    this.submittingForm = true;

    const studio: StudioModel = Object.assign(new StudioModel(), this.studioForm.value);

    this.registerService.createStudio(studio)
      .subscribe(
        studio => this.actionsForSuccess(studio),
        error => this.actionsForError(error)
      )
  }

  // Private Methods
  buildStudioForm() {
    this.studioForm = this.formBuilder.group({
      name: [null, [Validators.required, Validators.minLength(4)]],
      email: [null, [Validators.required, Validators.email, Validators.minLength(10)]],
      password: [null, [Validators.required, Validators.minLength(6)]]
    })
  }

  actionsForSuccess(studio: StudioModel) {
    toastr.success('Cadastro realizado com sucesso!');

    setTimeout(() => {
      this.router.navigateByUrl('/');
    }, 3000);
  }

  actionsForError(error) {
    this.submittingForm = false;
    toastr.error('Ocorreu um erro, tente novamente!');
  }
}
