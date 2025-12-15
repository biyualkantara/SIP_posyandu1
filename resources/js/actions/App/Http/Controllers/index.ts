import DuspyController from './DuspyController'
import KaderKehadiranController from './KaderKehadiranController'
import WuspusController from './WuspusController'
import SipintarStuntingController from './SipintarStuntingController'
import SipintarChatbotController from './SipintarChatbotController'
import KaderPosyanduController from './KaderPosyanduController'
import BayiController from './BayiController'
const Controllers = {
    DuspyController: Object.assign(DuspyController, DuspyController),
KaderKehadiranController: Object.assign(KaderKehadiranController, KaderKehadiranController),
WuspusController: Object.assign(WuspusController, WuspusController),
SipintarStuntingController: Object.assign(SipintarStuntingController, SipintarStuntingController),
SipintarChatbotController: Object.assign(SipintarChatbotController, SipintarChatbotController),
KaderPosyanduController: Object.assign(KaderPosyanduController, KaderPosyanduController),
BayiController: Object.assign(BayiController, BayiController),
}

export default Controllers