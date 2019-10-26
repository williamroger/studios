import { Router } from '@angular/router';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { LoadingController, ToastController } from '@ionic/angular';

import { AuthService } from './../auth.service';
import { UserModel } from './shared/UserModel';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  formLogin: FormGroup;
  submittingForm: boolean = false;

  constructor(private formBuild: FormBuilder, 
              private authAuth: AuthService, 
              private router: Router,
              private loadingCtrl: LoadingController,
              private toastCtrl: ToastController) { }

  ngOnInit() {
    this.builCustomerForm();
  }

  async presentLoading() {
    const loading = await this.loadingCtrl.create({
      message: 'Entrando...',
      duration: 5000
    });
    await loading.present();

    const { role, data } = await loading.onDidDismiss();
  }

  submitForm() {
    this.submittingForm = true;

    const user: UserModel = Object.assign(new UserModel(), this.formLogin.value);

    this.presentLoading();

    this.authAuth.login(user).subscribe(
      data => {
        if(data.success && data.userPayload.is_customer == 1) {
          this.actionForSuccess(data.msg);
          this.authAuth.setLoggedIn(true);
          localStorage.setItem('userLoggedIn', JSON.stringify(data.userPayload));
        }
      },
      error => this.actionForError(error.msg)
    );
  }

  private builCustomerForm() {
    this.formLogin = this.formBuild.group({
      email: [null, [Validators.required, Validators.email, Validators.minLength(10)]],
      password: [null, [Validators.required, Validators.minLength(8)]]
    });
  }

  private actionForSuccess(message: string) {
    this.router.navigateByUrl('tabs/studios');
  }

  private actionForError(error) {
    this.submittingForm = false;
    this.presentToast(error);
  }

  async presentToast(msg: string) {
    const toast = await this.toastCtrl.create({
      message: msg,
      color: 'light',
      duration: 5000
    });
    toast.present();
  }
}
