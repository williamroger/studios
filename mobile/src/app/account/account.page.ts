import { AuthService } from './../login/shared/auth.service';
import { AlertController } from '@ionic/angular';
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

  constructor(public accountService: AccountService, 
              public formBuilder: FormBuilder, 
              private toastCtrl: ToastController, 
              public navCtrl: NavController,
              public auth: AuthService,
              public alert: AlertController ) { }


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
  }

  actionsForError(error) {
    this.submittingForm = false;
    this.presentToast('Ocorreu um erro, tente novamente!');
  }

  async presentToast(message: string) {
    const toast = await this.toastCtrl.create({
      message,
      duration: 2000,
      color: 'primary'
    });
    toast.present();
  }

  async presentAlert() {
    const alert = await this.alert.create({
      header: 'Confirmar',
      message: '<strong>Tem certeza que deseja sair da sua conta?</strong>',
      buttons: [
      {
        text: 'Sim',
        cssClass: 'secondary',
        handler: async() => {
          this.logout();
        }
      },
      {
        text: 'Não',
        role: 'cancel'
      }
      ]
    });

    await alert.present();
  }

  logout(){
    this.navCtrl.navigateRoot('');
    this.auth.setLoggedIn(false);
    localStorage.clear();
  }
}
