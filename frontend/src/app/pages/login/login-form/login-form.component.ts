import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

import { AuthService } from '../../../auth.service';
import { UserModel } from './../shared/user.model';

@Component({
  selector: 'app-login-form',
  templateUrl: './login-form.component.html',
  styleUrls: ['./login-form.component.scss']
})
export class LoginFormComponent implements OnInit {

  formLogin: FormGroup;
  submittingForm: boolean = false;

  constructor(private formBuilder: FormBuilder,
              private authService: AuthService) { }

  ngOnInit() {
    this.buildStudioForm();
  }

  submitForm() {
    this.submittingForm = true;

    const user: UserModel = Object.assign(new UserModel(), this.formLogin.value);

    this.authService.login(user)
      .subscribe(
        data => console.log(data)
      );

    // stop here if form is invalid
    if (this.formLogin.invalid) {
        return;
    }
  }

  buildStudioForm() {
    this.formLogin = this.formBuilder.group({
      email: [null, [Validators.required, Validators.email, Validators.minLength(10)]],
      password: [null, [Validators.required, Validators.minLength(8)]]
    })
  }

}
