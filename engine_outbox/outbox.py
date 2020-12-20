import pusher
import pymysql
import time
from datetime import datetime
import pandas as pd

con = pymysql.connect('localhost', 'root', '', 'messages')
pusher_client = pusher.Pusher(
    app_id='1107738',
    key='5ca5d1e4e0e74c0266f2',
    secret='55a786173c3b9d62e29f',
    cluster='ap1',
    ssl=True
)

if __name__ == '__main__':
    while True:
        cur = con.cursor()
        selectOutbox = "select * from tb_outbox where tb_outbox.status = '0'"
        cur.execute(selectOutbox)
        dataOutbox = cur.fetchall()
        con.commit()
        if cur.rowcount == 0:
            print("Tidak ada pesan baru")
        else:
            for row in dataOutbox:
                id_sender = row[3]
                tanggal = row[2]
                pesan = row[1]

                array = {'id_sender': [id_sender], 'pesan': [pesan]}

                pusher_client.trigger(
                    'bot_channel', 'bot_event', {
                        'data': array
                    })
                updateOutbox = "update tb_outbox set status ='1' where id = %s" % (
                    row[0])
                print("send chat to user with id : %s" % row[3])
                cur.execute(updateOutbox)
                con.commit()
                sql = "Insert into tb_chat (pesan, id_sender, tipe_pesan , status)  values (%s, %s, %s, %s) "
                cur.execute(sql, (pesan, id_sender, '2', '1'))
                con.commit()

        time.sleep(6)
