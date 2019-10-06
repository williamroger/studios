import { AccountService } from './shared/account.service';
import { CustomerModel } from './../register/shared/customer';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ToastController } from '@ionic/angular';
import { NavController} from '@ionic/angular';
import { CityModel } from './shared/CityModel';

@Component({
  selector: 'app-account',
  templateUrl: './account.page.html',
  styleUrls: ['./account.page.scss'],
})
export class AccountPage implements OnInit {

  customerForm: FormGroup;
  cities: Array<CityModel>;
  customer: CustomerModel = new CustomerModel();
  submittingForm = false;

  /*imaskPhone = {
    mask: '(00) 00000-0000'
  };

  imaskCPF = {
    mask: '000.000.000-00'
  };*/

  /*error_messages = {
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
  }*/

  constructor(public accountService: AccountService, 
              public formBuilder: FormBuilder, 
              private toastCtrl: ToastController, 
              public navCtrl: NavController ) { }

  ngOnInit() {
    this.loadCities();
    this.loadCustomerForm();
    this.buildCustomerForm();
  }

  updateForm() {
    this.submittingForm = true;
    const customer: CustomerModel = Object.assign(new CustomerModel(), this.customerForm.value);
    const userLoggedIn = JSON.parse(localStorage.getItem('userLoggedIn'));

    this.accountService.updateCustomer(customer).subscribe(
      data => {
        this.actionsForSuccess(customer);
        userLoggedIn.city_id = data.city_id;
        localStorage.removeItem('userLoggedIn');
        localStorage.setItem('userLoggedIn', JSON.stringify(userLoggedIn));
        //setTimeout(() => {
        this.refresh();
        //}, 3000);
      },
      error => this.actionsForError(error)
    )
  }

  private loadCities() {
    this.accountService.getCitiesByStateId()
      .subscribe(
        cities => this.cities = cities
      );
  }

  private loadCustomerForm() {
    this.accountService.getCustomerById()
    .subscribe(
      (customer) => {
        this.customer = customer
        this.customerForm.patchValue(customer);
      }
    );
  }

  buildCustomerForm() {
    this.customerForm = this.formBuilder.group({
      id: [null],
      firstname: [null, [Validators.required, Validators.minLength(4)]],
      lastname: [null, [Validators.required, Validators.minLength(4)]],
      phone: [null, [Validators.required, Validators.minLength(9)]],
      cpf: [null, [Validators.required, Validators.minLength(11), Validators.maxLength(11)]],
      city_id: [null, [Validators.required]],
      image: ['imagepath']
    });
  }

  actionsForSuccess(customer: CustomerModel) {
    this.presentToast('Atualizado com sucesso!');
    this.submittingForm = false;
    // setTimeout(() => {
    //   this.router.navigateByUrl('/');
    // }, 3000);
  }

  actionsForError(error) {
    this.submittingForm = false;
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

  private refresh() {
    window.location.reload();
  }
  logout(){
    this.navCtrl.navigateRoot('');
    this.refresh();
  }
}
