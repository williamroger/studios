import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { CustomerModel } from '../register/shared/customer';
import { RegisterService } from '../register/shared/register.service';
import { ToastController } from '@ionic/angular';
import { NavController} from '@ionic/angular';
import { LoadingController } from '@ionic/angular';

@Component({
  selector: 'app-register',
  templateUrl: './register.page.html',
  styleUrls: ['./register.page.scss'],
})
export class RegisterPage implements OnInit {

  customerForm: FormGroup;
  customer: CustomerModel = new CustomerModel();

  error_messages = {
    'firstname': [
      { type: 'required', message: 'este campo é obrigatório'},
      { type: 'minlength', message: 'deve ter no mínimo 4 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 150 caracteres' },
      //{ type: 'pattern', message: 'Informe um nome válido' }
    ],
    'lastname': [
      { type: 'required', message: 'este campo é obrigatório'},
      { type: 'minlength', message: 'deve ter no mínimo 4 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 150 caracteres' },
      //{ type: 'pattern', message: 'Informe um sobrenome válido' }
    ],
    'email': [
      { type: 'required', message: 'este campo é obrigatório' },
      { type: 'minlength', message: 'deve ter no mínimo 6 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 40 caracteres' },
      //{ type: 'pattern', message: 'Informe um email válido' }
    ],
    'password': [
      { type: 'required', message: 'este campo é obrigatório' },
      { type: 'minlength', message: 'deve ter no mínimo 8 caracteres' },
      { type: 'maxlength', message: 'deve ter no máximo 30 caracteres' }
    ]
  }

  constructor(
    public registerService: RegisterService,
    public formBuilder: FormBuilder,
    private toastCtrl: ToastController,
    public navCtrl: NavController,
    public loadingCtrl: LoadingController
  ) { }

  ngOnInit() {
    this.buildCustomerForm();
  }

  async presentLoading() {
    const loading = await this.loadingCtrl.create({
      message: 'Cadastrando',
      duration: 1000
    });
    await loading.present();

    const { role, data } = await loading.onDidDismiss();
  }

  submitForm() {
    const customer: CustomerModel = Object.assign(new CustomerModel(), this.customerForm.value);

    this.presentLoading();

    this.registerService.createCustumer(customer)
      .subscribe(
        studio => this.actionsForSuccess(customer),
        error => this.actionsForError(error)
      )
  }

  // Private Methods
  buildCustomerForm() {
    this.customerForm = this.formBuilder.group({
      firstname: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(4),
        Validators.maxLength(150),
        //Validators.pattern("^[^0-9]$")
      ])),
      lastname: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(4),
        Validators.maxLength(150),
        //Validators.pattern("^[^0-9]$")
      ])),
      email: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(6),
        Validators.maxLength(100),
        //Validators.pattern("[^0-9]+[a-zA-Z0-9]+(@[A-Za-z])+(\.[a-zA]),g")
      ])),
      password: new FormControl(null, Validators.compose([
        Validators.required,
        Validators.minLength(8),
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

  rotaLogin(){
    this.navCtrl.navigateRoot('');
  }

}
