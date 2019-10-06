import { TestBed } from '@angular/core/testing';

import { InfoRoomsService } from './info-rooms.service';

describe('InfoRoomsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: InfoRoomsService = TestBed.get(InfoRoomsService);
    expect(service).toBeTruthy();
  });
});
