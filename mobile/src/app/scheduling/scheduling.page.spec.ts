import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SchedulingPage } from './scheduling.page';

describe('SchedulingPage', () => {
  let component: SchedulingPage;
  let fixture: ComponentFixture<SchedulingPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SchedulingPage ],
      schemas: [CUSTOM_ELEMENTS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SchedulingPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
