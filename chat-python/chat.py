# -*- coding: utf-8 -*-
# Python version:  2.7
# GUI by designer-qt4

from __future__ import print_function
from PyQt4 import QtCore, QtGui
from time import sleep
import requests as rq
import Queue
import json
import sys
Queue.Queue
reload(sys)
sys.setdefaultencoding('utf-8')

sess = rq.Session()

login_url = "http://localhost/testCount/login"
chat_url = "http://localhost/testCount/chat"
new_msg_url = "http://localhost/testCount/newMsg"
logout_url = "http://localhost/testCount/logout"

try:
    _fromUtf8 = QtCore.QString.fromUtf8
except AttributeError:
    def _fromUtf8(s):
        return s

try:
    _encoding = QtGui.QApplication.UnicodeUTF8

    def _translate(context, text, disambig):
        return QtGui.QApplication.translate(context, text, disambig, _encoding)
except AttributeError:
    def _translate(context, text, disambig):
        return QtGui.QApplication.translate(context, text, disambig)

class Ui_Chat(QtGui.QMainWindow, QtGui.QTextCursor, object):
    def setupUi(self, Chat):
        # Thread
        self.logged_in = False
        self.login_thread = Login_Thread()
        self.new_msg_thread = Send_Thread()
        self.logout_thread = Logout_Thread()
        Chat.setObjectName(_fromUtf8("Chat"))
        Chat.resize(633, 429)
        self.tabWidget = QtGui.QTabWidget(Chat)
        self.tabWidget.setGeometry(QtCore.QRect(10, 10, 611, 401))
        self.tabWidget.setObjectName(_fromUtf8("tabWidget"))
        self.login_tab = QtGui.QWidget()
        self.login_tab.setObjectName(_fromUtf8("login_tab"))
        self.nickname_field = QtGui.QLineEdit(self.login_tab)
        self.nickname_field.setGeometry(QtCore.QRect(54, 80, 221, 41))
        self.nickname_field.setObjectName(_fromUtf8("nickname_field"))
        self.password_field = QtGui.QLineEdit(self.login_tab)
        self.password_field.setGeometry(QtCore.QRect(54, 140, 221, 41))
        self.password_field.setEchoMode(QtGui.QLineEdit.Password)
        self.password_field.setObjectName(_fromUtf8("password_field"))
        self.login_btn = QtGui.QPushButton(self.login_tab)
        self.login_btn.setGeometry(QtCore.QRect(120, 210, 85, 41))
        self.login_btn.setObjectName(_fromUtf8("login_btn"))
        self.login_noti = QtGui.QLabel(self.login_tab)
        self.login_noti.setEnabled(True)
        self.login_noti.setGeometry(QtCore.QRect(57, 30, 111, 31))
        self.login_noti.setObjectName(_fromUtf8("login_noti"))
        self.tabWidget.addTab(self.login_tab, _fromUtf8(""))
        self.chat_tab = QtGui.QWidget()
        self.chat_tab.setObjectName(_fromUtf8("chat_tab"))
        self.msgs_box = QtGui.QPlainTextEdit(self.chat_tab)
        self.msgs_box.setGeometry(QtCore.QRect(8, 20, 591, 281))
        self.msgs_box.setReadOnly(True)
        self.msgs_box.setObjectName(_fromUtf8("msgs_box"))
        self.new_msg_field = QtGui.QLineEdit(self.chat_tab)
        self.new_msg_field.setGeometry(QtCore.QRect(7, 320, 501, 41))
        self.new_msg_field.setObjectName(_fromUtf8("new_msg_field"))
        self.send_btn = QtGui.QPushButton(self.chat_tab)
        self.send_btn.setGeometry(QtCore.QRect(528, 319, 71, 41))
        self.send_btn.setObjectName(_fromUtf8("send_btn"))
        self.tabWidget.addTab(self.chat_tab, _fromUtf8(""))
        self.settings_tab = QtGui.QWidget()
        self.settings_tab.setObjectName(_fromUtf8("settings_tab"))
        self.logout_btn = QtGui.QPushButton(self.settings_tab)
        self.logout_btn.setGeometry(QtCore.QRect(258, 310, 85, 41))
        self.logout_btn.setObjectName(_fromUtf8("logout_btn"))
        self.tabWidget.addTab(self.settings_tab, _fromUtf8(""))
        self.retranslateUi(Chat)
        self.tabWidget.setCurrentIndex(0)
        QtCore.QMetaObject.connectSlotsByName(Chat)
        w.chat_tab.setEnabled(False)
        w.settings_tab.setEnabled(False)
        w.msgs_box.setEnabled(False)

    def retranslateUi(self, Chat):
        self.login_noti.setText(_translate("Chat", "", None))
        Chat.setWindowTitle(_translate("Chat", "Chat", None))
        self.nickname_field.setPlaceholderText(_translate("Chat", " Nickname", None))
        self.password_field.setPlaceholderText(_translate("Chat", " Password", None))
        self.login_btn.setText(_translate("Chat", "Login", None))
        self.tabWidget.setTabText(self.tabWidget.indexOf(self.login_tab), _translate("Chat", "Login", None))
        self.send_btn.setText(_translate("Chat", "Send", None))
        self.new_msg_field.setPlaceholderText(_translate("Chat", "New msg...", None))
        self.msgs_box.setPlainText(_translate("Chat", "", None))
        self.tabWidget.setTabText(self.tabWidget.indexOf(self.chat_tab), _translate("Chat", "Chat", None))
        self.logout_btn.setText(_translate("Chat", "Logout", None))
        self.tabWidget.setTabText(self.tabWidget.indexOf(self.settings_tab), _translate("Chat", "Settings", None))
        # Signals
        self.connect(self.login_btn, QtCore.SIGNAL('clicked()'), self.test_login)
        self.connect(self.login_btn, QtCore.SIGNAL('login()'), self.test_login)
        self.connect(self.login_thread, QtCore.SIGNAL('get_data(QString)'), self.set_data)

        self.connect(self.send_btn, QtCore.SIGNAL('clicked()'), self.new_msg)
        self.connect(self.send_btn, QtCore.SIGNAL('new_msg()'), self.new_msg)
        self.connect(self.new_msg_field, QtCore.SIGNAL('returnPressed()'), self.new_msg)

        self.connect(self.logout_btn, QtCore.SIGNAL('clicked()'), self.logout)
        self.connect(self.logout_btn, QtCore.SIGNAL('logout()'), self.logout)

    def test_login(self):
        self.login_thread.start()
        self.login_thread.nickname = str(self.nickname_field.text())
        self.login_thread.password = str(self.password_field.text())

    def set_data(self, msgs):
        self.msgs_box.appendPlainText(msgs)

    def new_msg(self):
        self.new_msg_thread.start()
        self.new_msg_thread.nickname = str(self.nickname_field.text())
        self.new_msg_thread.msg = str(self.new_msg_field.text())
        self.new_msg_field.setText(_translate("Chat", "", None))
        # print(1)

    def logout(self):
        self.login_thread.terminate()
        self.new_msg_thread.terminate()
        self.logout_thread.start()
        self.logout_thread.wait()

class Logout_Thread(QtCore.QThread):

    def __init__(self, parent=None):
        super(Logout_Thread, self).__init__(parent)

    def run(self):
        self.emit(QtCore.SIGNAL('logout()'))
        with sess as s:
            logout = s.get(logout_url)  # noqa
            w.msgs_box.clear()
            w.chat_tab.setEnabled(False)
            w.settings_tab.setEnabled(False)
            w.msgs_box.setEnabled(False)
            # Disable login tab
            w.login_tab.setEnabled(True)
            w.tabWidget.setCurrentIndex(0)
            w.login_noti.setText(_translate("Chat", "Logged Out !", None))
            w.nickname_field.setText(_translate("Chat", "", None))
            w.password_field.setText(_translate("Chat", "", None))

class Send_Thread(QtCore.QThread, object):

    def __init__(self, parent=None):
        super(Send_Thread, self).__init__(parent)
        self.msg = None
        self.nickname = None

    def run(self):
        self.emit(QtCore.SIGNAL('new_msg()'))
        msg_data = {
            "nickname": self.nickname,
            "msg": self.msg
        }
        with sess as s:
            post_new_msg = s.post(new_msg_url, data=msg_data)  # noqa
            # print(post_new_msg.content)


class Login_Thread(QtCore.QThread, object):

    def __init__(self, parent=None):
        super(Login_Thread, self).__init__(parent)
        self.logged_in = None
        self.nickname = None
        self.password = None

    def run(self):
        self.emit(QtCore.SIGNAL('login()'))
        with sess as s:
            # print self.nickname
            # print self.password
            login_data = {
                'nickname': self.nickname,
                'password': self.password
            }
            # Post data
            test_login = json.loads(s.post(login_url, data=login_data).content)
            if(test_login['success'] is False):
                w.chat_tab.setEnabled(True)
                w.settings_tab.setEnabled(True)
                w.msgs_box.setEnabled(True)
                # Disable login tab
                w.login_tab.setEnabled(False)
                w.tabWidget.setCurrentIndex(1)
                w.login_noti.setText(_translate("Chat", "Logged in !", None))
                box = ""
                try:
                    msgs = json.loads(s.get(chat_url).content)
                    for m in range(len(msgs)):
                        box = "[ %s ][ %s ] : %s" % (msgs[m]['msg_date'], msgs[m]['msg_from'], msgs[m]['msg_content'])
                        self.emit(QtCore.SIGNAL('get_data(QString)'), box)
                        self.last_id = len(msgs)
                except Exception as e:
                    # print(e)
                    self.last_id = 0
                    pass
                while 1:
                    with sess as s:
                        try:
                            msgs = json.loads(s.get(chat_url).content)
                            box = ""
                            box = "[ %s ][ %s ] : %s" % (msgs[self.last_id]['msg_date'], msgs[self.last_id]['msg_from'], msgs[self.last_id]['msg_content'])
                            self.emit(QtCore.SIGNAL('get_data(QString)'), box)
                            self.last_id += 1
                            sleep(1)
                        except Exception as e:  # noqa
                            # print(e)
                            sleep(4)
                            pass
            else:
                # login fail
                w.login_noti.setText(_translate("Chat", "", None))
                sleep(1)
                w.login_noti.setText(_translate("Chat", "FAIL: Unable to login", None))
                pass


if __name__ == '__main__':
    app = QtGui.QApplication(sys.argv)
    w = Ui_Chat()
    w.setupUi(w)
    w.setFixedSize(w.size())
    w.show()
    app.exec_()
