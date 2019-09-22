import { AccountService } from './shared/account.service';
import { CustomerModel } from './../register/shared/customer';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ToastController } from '@ionic/angular';

@Component({
  selector: 'app-account',
  templateUrl: './account.page.html',
  styleUrls: ['./account.page.scss'],
})
export class AccountPage implements OnInit {

  customerForm: FormGroup;
  customer: CustomerModel = new CustomerModel();

  error_messages = {
    'name': [
      { type: 'required', message: 'informe o seu nome!'},
      { type: 'minlength', message: 'deve ter no mínimo 4 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 150 caracteres' }
    ],
    'phone': [
      { type: 'required', message: 'informe o seu phone!'},
      { type: 'minlength', message: 'deve ter no mínimo 8 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 12 caracteres' }
    ],
    'cpf': [
      { type: 'required', message: 'informe o seu cpf!'},
      { type: 'minlength', message: 'deve ter no mínimo 11 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 11 caracteres' }
    ],
    'email': [
      { type: 'required', message: 'informe o seu email!' },
      { type: 'minlength', message: 'deve ter no mínimo 10 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 100 caracteres' }
    ]
  }

  constructor(public accountService: AccountService, public formBuilder: FormBuilder, private toastCtrl: ToastController ) { }

  ngOnInit() {
    this.buildCustomerForm();
  }

  updateForm() {
    const customer: CustomerModel = Object.assign(new CustomerModel(), this.customerForm.value);

    this.accountService.updateCustomer(customer).subscribe(
      studio => this.actionsForSuccess(customer),
      error => this.actionsForError(error)
    )
  }

  // Private Methods
  buildCustomerForm() {
    this.customerForm = this.formBuilder.group({
      id: new FormControl(4),
      name: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(4),
        Validators.maxLength(150)
      ])),
      phone: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(8),
        Validators.maxLength(14)
      ])),
      cpf: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(11),
        Validators.maxLength(11)
      ])),
      city_id: new FormControl(1),
      email: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(10),
        Validators.maxLength(100)
      ]))
    })
  }

  actionsForSuccess(customer: CustomerModel) {
    this.presentToast('Atualizado com sucesso!');

    // setTimeout(() => {
    //   this.router.navigateByUrl('/');
    // }, 3000);
  }

  actionsForError(error) {
    this.presentToast('Ocorreu um erro, tente novamente!');
  }

  // register() {
  //   console.log('name: ', this.registerForm.value.name);
  //   console.log('email: ', this.registerForm.value.email);
  //   console.log('password: ', this.registerForm.value.password);
  // }

  async presentToast(message: string) {
    const toast = await this.toastCtrl.create({
      message,
      duration: 2000,
      color: 'primary'
    });
    toast.present();
  }
}
