import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-login-form',
  templateUrl: './login-form.component.html',
  styleUrls: ['./login-form.component.scss']
})
export class LoginFormComponent implements OnInit {

  studioForm: FormGroup;
  submittingForm: boolean = false;

  constructor(private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.buildStudioForm();
  }

  submitForm() {
    this.submittingForm = true;

    // stop here if form is invalid
    if (this.studioForm.invalid) {
        return;
    }
  }

  buildStudioForm() {
    this.studioForm = this.formBuilder.group({
      email: [null, [Validators.required, Validators.email, Validators.minLength(10)]],
      password: [null, [Validators.required, Validators.minLength(6)]]
    })
  }

}
