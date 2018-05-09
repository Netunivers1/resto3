import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NosPresentationComponent } from './nos_presentation.component';

describe('NosPresentationComponent', () => {
  let component: NosPresentationComponent;
  let fixture: ComponentFixture<NosPresentationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NosPresentationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NosPresentationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
