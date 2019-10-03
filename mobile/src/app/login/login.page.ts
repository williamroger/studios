import { Router } from '@angular/router';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { NavController} from '@ionic/angular';
import { AuthService } from './shared/auth.service';

import { ToastController } from '@ionic/angular';
import { UserModel } from './shared/UserModel';

//import toastr from 'toastr';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  formLogin: FormGroup;
  submittingForm = false;

  constructor(public navCtrl: NavController, public formBuild: FormBuilder, public auth: AuthService, public router: Router) { }

  ngOnInit() {
    this.builCustomerForm();
  }

  rotaEntrar(){
    this.navCtrl.navigateRoot('tabs/tabs/home');
  }

  rotaCadastro(){
    this.navCtrl.navigateRoot('register');
  }

  submitForm() {
    this.submittingForm = true;
    const user: UserModel = Object.assign(new UserModel(), this.formLogin.value);
    const userError = {msg: 'Error!'};

    this.auth.login(user).subscribe(
      data => {
        if(data.success && data.userPayload.is_customer == 1) {
          this.actionForSuccess(data.msg);
          this.auth.setLoggedIn(true);
          localStorage.setItem('userLoggedIn', JSON.stringify(data.userPayload));
        }
        else{
          this.actionForError(userError);
        }
      },
      error => this.actionForError(error)
    );
  }

  private builCustomerForm() {
    this.formLogin = this.formBuild.group({
      email: [null, [Validators.required, Validators.email, Validators.minLength(10)]],
      password: [null, [Validators.required, Validators.minLength(8)]]
    });
  }

  private actionForSuccess(message: string) {
    //toastr.success(message);

    setTimeout(() => {
      this.router.navigateByUrl('tabs/tabs/home');
    }, 3000);
  }

  private actionForError(error) {
    this.submittingForm = false;
    //toastr.error(error.msg);
  }
}
