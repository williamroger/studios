import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { CustomerModel } from '../register/shared/customer';
import { RegisterService } from '../register/shared/register.service';
import { ToastController } from '@ionic/angular';

@Component({
  selector: 'app-register',
  templateUrl: './register.page.html',
  styleUrls: ['./register.page.scss'],
})
export class RegisterPage implements OnInit {

  customerForm: FormGroup;
  customer: CustomerModel = new CustomerModel();

  error_messages = {
    'name': [
      { type: 'required', message: 'este campo é obrigatório'},
      { type: 'minlength', message: 'deve ter no mínimo 4 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 150 caracteres' }
    ],
    'email': [
      { type: 'required', message: 'este campo é obrigatório' },
      { type: 'minlength', message: 'deve ter no mínimo 6 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 100 caracteres' }
    ],
    'password': [
      { type: 'required', message: 'este campo é obrigatório' },
      { type: 'minlength', message: 'deve ter no mínimo 6 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 30 caracteres' }
    ]
  }

  constructor(
    public registerService: RegisterService,
    public formBuilder: FormBuilder,
    private toastCtrl: ToastController 
  ) { }

  ngOnInit() {
    this.buildCustomerForm();
  }

  submitForm() {
    const customer: CustomerModel = Object.assign(new CustomerModel(), this.customerForm.value);

    this.registerService.createCustumer(customer)
      .subscribe(
        studio => this.actionsForSuccess(customer),
        error => this.actionsForError(error)
      )
  }

  // Private Methods
  buildCustomerForm() {
    this.customerForm = this.formBuilder.group({
      name: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(4),
        Validators.maxLength(150)
      ])),
      email: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(6),
        Validators.maxLength(100)
      ])),
      password: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(6),
        Validators.maxLength(30)
      ]))
    })
  }

  actionsForSuccess(customer: CustomerModel) {
    this.presentToast('Cadastro realizado com sucesso!');

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
