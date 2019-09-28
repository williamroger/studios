import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../../auth.service';
import { UserModel } from './../shared/user.model';

import toastr from 'toastr';

@Component({
  selector: 'app-login-form',
  templateUrl: './login-form.component.html',
  styleUrls: ['./login-form.component.scss']
})
export class LoginFormComponent implements OnInit {

  formLogin: FormGroup;
  submittingForm: boolean = false;

  constructor(private formBuilder: FormBuilder,
              private authService: AuthService,
              private router: Router) { }

  ngOnInit() {
    this.buildStudioForm();
  }

  submitForm() {
    this.submittingForm = true;

    const user: UserModel = Object.assign(new UserModel(), this.formLogin.value);
    const userError = {msg: 'Espertinho, você não pode entrar aqui!'};

    this.authService.login(user)
      .subscribe(
        data => {
          if (data.success && data.userPayload.is_studio == 1)
            this.actionsForSuccess(data.msg);
          else
            this.actionsForError(userError);
        },
        error => this.actionsForError(error)
      );
  }

  private buildStudioForm() {
    this.formLogin = this.formBuilder.group({
      email: [null, [Validators.required, Validators.email, Validators.minLength(10)]],
      password: [null, [Validators.required, Validators.minLength(8)]]
    })
  }

  private actionsForSuccess(message: string) {
    toastr.success(message);

    setTimeout(() => {
      this.router.navigateByUrl('/dashboard');
    }, 3000)
  }

  private actionsForError(error) {
    this.submittingForm = false;
    toastr.error(error.msg);
  }
}
